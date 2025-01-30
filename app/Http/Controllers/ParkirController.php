<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tarif;
use App\Models\Parkir;
use App\Models\Pegawai;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ParkirController extends Controller
{
    private function getValidatedDates(Request $request)
    {
        $tanggalMulai = Carbon::createFromFormat('Y-m-d', $request->input('tanggal_mulai', Carbon::now()->startOfMonth()->format('Y-m-d')))->startOfDay();
        $tanggalSelesai = Carbon::createFromFormat('Y-m-d', $request->input('tanggal_selesai', Carbon::now()->endOfMonth()->format('Y-m-d')))->endOfDay();

        return [$tanggalMulai, $tanggalSelesai];
    }

    public function tampil()
    {
        $tarif = Tarif::get();
        $parkir = Parkir::with('tarif')->orderBy('tanggal', 'desc')->get();;
        $jam = Carbon::now('Asia/Makassar')->format('H:i');
        return view('manajemen-parkir.tampil', compact('tarif', 'parkir', 'jam'));
    }

    public function scanKeluar()
    {
        return view('manajemen-parkir.scan-keluar');
    }

    public function cetakParkir($id)
    {
        $parkir = Parkir::with('tarif')->findOrFail($id);
        $pdf = Pdf::loadView('manajemen-parkir.cetak-parkir', compact('parkir'));
        return $pdf->stream('Struk_' . $parkir->plat_kendaraan . '.pdf');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'plat_kendaraan' => 'required|string|max:255',
            'jenis_tarif' => 'required|exists:tarif,id',
            'jam_masuk' => 'required|date_format:H:i',
        ]);

        $parkir = new Parkir();
        $parkir->plat_kendaraan = $request->plat_kendaraan;
        $parkir->tarif_id = $request->jenis_tarif;
        $parkir->jam_masuk = $request->jam_masuk;
        $parkir->tanggal = Carbon::now()->format('Y-m-d');
        $parkir->status = Parkir::STATUS_TERPARKIR;
        $parkir->save();

        return back()->with('success', 'Data Berhasil Ditambahkan');
    }

    public function keluar(Request $request, $id)
    {
        $request->validate([
            'jam_keluar' => 'required|date_format:H:i',
        ]);

        $parkir = Parkir::findOrFail($id);
        $parkir->jam_keluar = $request->jam_keluar;
        $parkir->status = Parkir::STATUS_KELUAR;
        $parkir->update();

        return redirect()->route('manajemen-parkir.tampil')->with('success', 'Data berhasil diperbarui.');
    }

    public function processScanKeluar(Request $request)
    {
        try {
            // Validasi request
            $request->validate([
                'decodedText' => 'required|string'
            ]);

            // Waktu saat ini
            $keluar = Carbon::now('Asia/Makassar')->format('H:i');

            // Cari data parkir berdasarkan plat kendaraan dan status
            $parkir = Parkir::where('plat_kendaraan', $request->decodedText)
                ->where('status', Parkir::STATUS_TERPARKIR)
                ->first();

            // Jika data parkir tidak ditemukan
            if (!$parkir) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kendaraan tidak ditemukan atau sudah keluar.'
                ], 404);
            }

            // Update data parkir
            $parkir->update([
                'jam_keluar' => $keluar,
                'status' => Parkir::STATUS_KELUAR,
            ]);

            // Respons sukses
            return response()->json([
                'success' => true,
                'message' => 'Proses scan keluar berhasil.',
                'data' => [
                    'plat_kendaraan' => $parkir->plat_kendaraan,
                    'jam_keluar' => $parkir->jam_keluar,
                ]
            ]);
        } catch (\Exception $e) {
            // Penanganan kesalahan umum
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses scan keluar.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function laporan(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');
        $status = $request->input('status', null);

        $query = Parkir::with('tarif')->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);

        if (!is_null($status)) {
            $query->where('status', $status);
        }

        $dataParkir = $query->get();
        return view('laporan.parkir.parkir', compact('dataParkir', 'tanggalMulai', 'tanggalSelesai', 'status'));
    }

    public function cetakLaporan(Request $request)
    {
        // Ambil input tanggal dan status
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');
        $status = $request->input('status', null);

        // Validasi dan parsing tanggal
        try {
            $tanggalMulai = Carbon::parse($tanggalMulai);
            $tanggalSelesai = Carbon::parse($tanggalSelesai);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => 'Tanggal tidak valid.']);
        }

        // Query data parkir dengan filter tanggal dan status
        $query = Parkir::with('tarif')->whereBetween('tanggal', [
            $tanggalMulai->toDateString(),
            $tanggalSelesai->toDateString(),
        ]);

        // Filter berdasarkan status jika status tidak null
        if (!is_null($status)) {
            $query->where('status', $status);
        }

        // Ambil data dari query
        $dataParkir = $query->get();

        // Generate PDF
        $pdf = PDF::loadView('laporan.parkir.parkir_pdf', compact('dataParkir', 'tanggalMulai', 'tanggalSelesai', 'status'));

        return $pdf->stream('laporan-parkir-' . $tanggalMulai->format('Y-m-d') . '-sampai-' . $tanggalSelesai->format('Y-m-d') . '-status-' . ($status ?? 'semua') . '.pdf');
    }


    public function laporanPendapatan(Request $request)
    {
        [$tanggalMulai, $tanggalSelesai] = $this->getValidatedDates($request);
        $jenisTarif = $request->input('jenis_tarif', null);

        $query = Parkir::with('tarif')->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);

        if (!empty($jenisTarif)) {
            $query->whereHas('tarif', function ($q) use ($jenisTarif) {
                $q->where('jenis_tarif', $jenisTarif);
            });
        }

        $dataParkir = $query->get();
        $totalPendapatan = $dataParkir->sum(fn($parkir) => $parkir->tarif->tarif ?? 0);

        $jenisTarifList = Tarif::select('jenis_tarif')->distinct()->get();

        return view('laporan.pendapatan.pendapatan', compact('dataParkir', 'tanggalMulai', 'tanggalSelesai', 'jenisTarifList', 'totalPendapatan'));
    }

    public function cetakPendapatan(Request $request)
    {
        [$tanggalMulai, $tanggalSelesai] = $this->getValidatedDates($request);
        $jenisTarif = $request->input('jenis_tarif', null);

        $query = Parkir::with('tarif')->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);

        if ($jenisTarif) {
            $query->whereHas('tarif', function ($query) use ($jenisTarif) {
                $query->where('jenis_tarif', $jenisTarif);
            });
        }

        $dataParkir = $query->get();
        $totalPendapatan = $dataParkir->sum(fn($item) => $item->tarif->tarif ?? 0);

        $pdf = PDF::loadView('laporan.pendapatan.pendapatan_pdf', compact('dataParkir', 'tanggalMulai', 'tanggalSelesai', 'jenisTarif', 'totalPendapatan'));

        return $pdf->stream('laporan-pendapatan-' . $tanggalMulai->format('Y-m-d') . '-sampai-' . $tanggalSelesai->format('Y-m-d') . '-jenis-tarif-' . ($jenisTarif ?? 'semua') . '.pdf');
    }

    public function delete($id)
    {
        try {
            // Cari data parkir berdasarkan ID
            $parkir = Parkir::findOrFail($id);

            // Hapus data parkir
            $parkir->delete();

            // Redirect dengan pesan sukses
            return redirect()->route('manajemen-parkir.tampil')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            // Redirect dengan pesan error jika terjadi kesalahan
            return redirect()->route('manajemen-parkir.tampil')->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    public function tampilkanKendaraanTerparkir()
    {
        // Mengambil data kendaraan yang terparkir
        $kendaraanTerparkir = Parkir::where('status', Parkir::STATUS_TERPARKIR)->get();

        // Mengirim data ke view
        return view('beranda', compact('kendaraanTerparkir'));
    }
}
