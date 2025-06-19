<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Denda;
use App\Models\Tarif;
use App\Models\Parkir;
use App\Models\Pegawai;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\ParkirPegawai;
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
        $tarif = Tarif::all();

        // Ambil data parkir dengan relasi tarif, user, urutkan berdasarkan waktu_masuk terbaru
        $parkir = Parkir::with('tarif', 'user')
            ->orderBy('waktu_masuk', 'desc')
            ->get();

        // Generate kode_parkir terbaru
        $last = Parkir::orderBy('id', 'desc')->first();
        $nextNumber = $last ? ((int)substr($last->kode_parkir, 2)) + 1 : 1;
        $kodeParkir = 'KP' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // Waktu sekarang sesuai timezone Makassar
        $jam = \Carbon\Carbon::now('Asia/Makassar')->format('H:i');

        return view('manajemen-parkir.tampil', compact('tarif', 'parkir', 'jam', 'kodeParkir'));
    }


    public function scanKeluar()
    {
        return view('manajemen-parkir.scan-keluar');
    }

    public function cetakParkir($id)
    {
        $parkir = Parkir::with('tarif')->findOrFail($id);
        $pdf = Pdf::loadView('manajemen-parkir.cetak-parkir', compact('parkir'))
            ->setPaper([0, 0, 226.77, 283.46], 'portrait'); // 58mm x 100mm dalam satuan points

        return $pdf->stream('Struk_' . $parkir->plat_kendaraan . '.pdf');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'plat_kendaraan' => 'required|string|max:255',
            'jenis_tarif' => 'required|exists:tarif,id',
            'user_id' => 'required|exists:tuser,id',
        ]);

        // Generate kode parkir otomatis
        $last = Parkir::orderBy('id', 'desc')->first();
        $nextNumber = $last ? ((int)substr($last->kode_parkir, 2)) + 1 : 1;
        $kodeParkir = 'KP' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // Simpan data parkir
        $parkir = new Parkir();
        $parkir->kode_parkir = $kodeParkir; // baru ditambahkan
        $parkir->plat_kendaraan = $request->plat_kendaraan;
        $parkir->tarif_id = $request->jenis_tarif;
        $parkir->user_id = $request->user_id;
        $parkir->waktu_masuk = now();
        $parkir->status = Parkir::STATUS_TERPARKIR; // pastikan konstanta ini didefinisikan di model Parkir
        $parkir->save();

        // Redirect ke struk/cetak jika ingin
        // return redirect()->route('parkir.struk', $parkir->id);

        return back()->with('success', 'Data Berhasil Ditambahkan');
    }



    public function keluar(Request $request, $id)
    {
        $request->validate([
            'waktu_keluar' => 'required|date',
        ]);

        $parkir = Parkir::with('tarif.kategori')->findOrFail($id);
        $waktuKeluar = Carbon::parse($request->waktu_keluar);

        if ($waktuKeluar->lt($parkir->waktu_masuk)) {
            return back()->withErrors(['waktu_keluar' => 'Waktu keluar tidak boleh lebih awal dari waktu masuk.']);
        }

        $parkir->waktu_keluar = $waktuKeluar;
        $parkir->status = Parkir::STATUS_KELUAR;
        $parkir->save();

        if (strtoupper($parkir->tarif->jenis_tarif) === 'INAP') {
            // Hitung durasi dalam menit lalu bulatkan ke atas ke jam penuh
            $durasiMenit = $parkir->waktu_masuk->diffInMinutes($waktuKeluar);
            $durasiJam = ceil($durasiMenit / 60);

            $batasJam = 48;

            if ($durasiJam > $batasJam) {
                $jamTerlambat = $durasiJam - $batasJam;

                $kategori = strtoupper($parkir->tarif->kategori->nama_kategori);
                $tarifPerJam = ($kategori === 'RODA 2') ? 10000 : 20000;

                $dendaTotal = $jamTerlambat * $tarifPerJam;

                // Simpan/update di tabel denda
                $parkir->denda()->updateOrCreate(
                    ['parkir_id' => $parkir->id],
                    [
                        'plat_kendaraan' => $parkir->plat_kendaraan,
                        'tanggal' => now()->toDateString(),
                        'nominal' => $dendaTotal,
                        'status' => 'Belum Dibayar',
                    ]
                );

                return redirect()->route('manajemen-denda.tampil')
                    ->with('warning', 'Kendaraan terkena denda karena melebihi batas waktu parkir.');
            }
        }

        return redirect()->route('manajemen-parkir.tampil')
            ->with('success', 'Kendaraan berhasil keluar tanpa denda.');
    }



    public function prosesScanKeluar(Request $request)
    {
        $decodedText = $request->input('decodedText');

        if (!$decodedText) {
            return response()->json([
                'success' => false,
                'message' => 'Data barcode tidak terbaca.',
            ]);
        }

        // Ambil data parkir yang belum keluar
        $parkir = Parkir::with('tarif.kategori')
            ->where('kode_parkir', $decodedText)
            ->whereNull('waktu_keluar')
            ->latest()
            ->first();

        if (!$parkir) {
            return response()->json([
                'success' => false,
                'message' => 'Data parkir tidak ditemukan.',
            ]);
        }

        if ($parkir->status === Parkir::STATUS_KELUAR) {
            return response()->json([
                'success' => false,
                'message' => 'Kendaraan sudah keluar sebelumnya.',
            ]);
        }

        $waktuKeluar = now();

        if ($waktuKeluar->lt($parkir->waktu_masuk)) {
            return response()->json([
                'success' => false,
                'message' => 'Waktu keluar tidak boleh sebelum waktu masuk.',
            ]);
        }

        // Hitung durasi dan denda (jika INAP)
        $dendaTotal = 0;
        $batasJam = 48;

        if (strtoupper($parkir->tarif->jenis_tarif) === 'INAP') {
            $durasiMenit = $parkir->waktu_masuk->diffInMinutes($waktuKeluar);
            $durasiJam = ceil($durasiMenit / 60);

            if ($durasiJam > $batasJam) {
                $jamTerlambat = $durasiJam - $batasJam;
                $kategori = strtoupper($parkir->tarif->kategori->nama_kategori);

                $tarifPerJam = ($kategori === 'RODA 2') ? 10000 : 20000;
                $dendaTotal = $jamTerlambat * $tarifPerJam;
            }
        }

        // Simpan data parkir
        $parkir->waktu_keluar = $waktuKeluar;
        $parkir->status = Parkir::STATUS_KELUAR;
        $parkir->save();

        // Simpan/update data denda jika ada
        if ($dendaTotal > 0 && method_exists($parkir, 'denda')) {
            $parkir->denda()->updateOrCreate(
                ['parkir_id' => $parkir->id],
                [
                    'plat_kendaraan' => $parkir->plat_kendaraan,
                    'tanggal' => now()->toDateString(),
                    'nominal' => $dendaTotal,
                    'status' => 'Belum Dibayar',
                ]
            );
        }

        return response()->json([
            'success' => true,
            'data' => [
                'plat_kendaraan' => $parkir->plat_kendaraan,
                'waktu_keluar' => $waktuKeluar->format('Y-m-d H:i'),
                'denda' => $dendaTotal,
                'redirect' => $dendaTotal > 0
                    ? route('manajemen-denda.tampil')
                    : route('manajemen-parkir.tampil'),
            ],
            'message' => $dendaTotal > 0
                ? 'Kendaraan terkena denda karena melebihi batas waktu parkir.'
                : 'Kendaraan berhasil keluar tanpa denda.'
        ]);
    }



    public function laporan(Request $request)
    {
        // Tanggal default (hari ini)
        $tanggalMulai = $request->tanggal_mulai ?? now()->format('Y-m-d');
        $tanggalSelesai = $request->tanggal_selesai ?? now()->format('Y-m-d');

        // Konversi ke datetime
        $start = Carbon::parse($tanggalMulai)->startOfDay();
        $end = Carbon::parse($tanggalSelesai)->endOfDay();

        // Ambil data parkir dengan filter
        $dataParkir = Parkir::with('tarif')
            ->whereBetween('waktu_masuk', [$start, $end])
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->orderBy('waktu_masuk', 'desc')
            ->get();

        return view('laporan.parkir.parkir', [
            'dataParkir' => $dataParkir,
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
        ]);
    }

    public function cetakLaporan(Request $request)
    {
        // Ambil input tanggal dan status dari form
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');
        $status = $request->input('status', null);

        // Validasi dan parsing tanggal
        try {
            $tanggalMulai = Carbon::parse($tanggalMulai)->startOfDay();
            $tanggalSelesai = Carbon::parse($tanggalSelesai)->endOfDay();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => 'Format tanggal tidak valid.']);
        }

        // Query data parkir, berdasarkan waktu_masuk dan status (jika ada)
        $query = Parkir::with('tarif')->whereBetween('waktu_masuk', [
            $tanggalMulai->startOfDay(),
            $tanggalSelesai->endOfDay(),
        ]);

        // Jika status diisi, filter berdasarkan kolom status
        if (!is_null($status)) {
            $query->where('status', $status); // 'Terparkir' atau 'Keluar'
        }

        // Eksekusi query
        $dataParkir = $query->get();

        // Generate PDF dengan view laporan
        $pdf = PDF::loadView('laporan.parkir.parkir_pdf', compact(
            'dataParkir',
            'tanggalMulai',
            'tanggalSelesai',
            'status'
        ));

        return $pdf->stream('laporan-parkir-' . $tanggalMulai->format('Y-m-d') . '-sampai-' . $tanggalSelesai->format('Y-m-d') . '-status-' . ($status ?? 'semua') . '.pdf');
    }


    public function laporanPendapatan(Request $request)
    {
        // Ambil input filter tanggal mulai dan selesai
        $tanggalMulai = $request->input('tanggal_mulai') ? Carbon::parse($request->input('tanggal_mulai')) : Carbon::now()->startOfMonth();
        $tanggalSelesai = $request->input('tanggal_selesai') ? Carbon::parse($request->input('tanggal_selesai')) : Carbon::now()->endOfMonth();

        // Ambil filter jenis tarif (boleh kosong = semua)
        $jenisTarif = $request->input('jenis_tarif');

        // Query parkir dengan relasi tarif dan denda, filter status Keluar, tanggal sesuai filter
        $queryParkir = Parkir::with(['tarif', 'denda'])
            ->where('status', 'Keluar')
            ->whereBetween('waktu_keluar', [$tanggalMulai->startOfDay(), $tanggalSelesai->endOfDay()]);

        // Jika filter jenis tarif dipilih, filter berdasarkan relasi tarif
        if ($jenisTarif) {
            $queryParkir->whereHas('tarif', function ($q) use ($jenisTarif) {
                $q->where('jenis_tarif', $jenisTarif);
            });
        }

        $dataParkir = $queryParkir->get();

        // Hitung pendapatan murni (tarif) dari dataParkir
        $pendapatanMurni = $dataParkir->sum(fn($item) => $item->tarif->tarif ?? 0);


        $pendapatanDenda = Denda::where('status', 'Sudah Dibayar')
            ->whereBetween('tanggal', [$tanggalMulai->startOfDay(), $tanggalSelesai->endOfDay()])
            ->when($jenisTarif, function ($q) use ($jenisTarif) {
                // Jika perlu, bisa join ke parkir dan tarif untuk filter jenis tarif
                $q->whereHas('parkir.tarif', function ($q2) use ($jenisTarif) {
                    $q2->where('jenis_tarif', $jenisTarif);
                });
            })
            ->sum('nominal');

        $totalPendapatan = $pendapatanMurni + $pendapatanDenda;

        // Ambil list jenis tarif untuk dropdown filter (unik)
        $jenisTarifList = Tarif::select('jenis_tarif')->distinct()->get();

        return view('laporan.pendapatan.pendapatan', compact(
            'tanggalMulai',
            'tanggalSelesai',
            'jenisTarifList',
            'dataParkir',
            'pendapatanMurni',
            'pendapatanDenda',
            'totalPendapatan'
        ));
    }



    public function cetakPendapatan(Request $request)
    {
        [$tanggalMulai, $tanggalSelesai] = $this->getValidatedDates($request);
        $jenisTarif = $request->input('jenis_tarif', null);

        $query = Parkir::with('tarif')->whereBetween('waktu_keluar', [$tanggalMulai, $tanggalSelesai]);

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


    public function dashboard()
    {
        $tanggalHariIni = Carbon::today();

        // Kendaraan non-pegawai
        $totalTerparkir = Parkir::whereDate('waktu_masuk', $tanggalHariIni)
            ->where('status', 'Terparkir')
            ->count();

        $totalKeluar = Parkir::whereDate('waktu_keluar', $tanggalHariIni)
            ->where('status', 'Keluar')
            ->count();

        $totalPendapatan = Parkir::whereDate('waktu_keluar', $tanggalHariIni)
            ->where('status', 'Keluar')
            ->with('tarif')
            ->get()
            ->sum(fn($parkir) => $parkir->tarif->tarif ?? 0);

        // Total denda hari ini
        $totalDenda = Denda::whereDate('tanggal', $tanggalHariIni)
            ->sum('nominal');

        // Kendaraan pegawai terparkir hari ini
        $kendaraanPegawaiTerparkir = ParkirPegawai::whereDate('tanggal', $tanggalHariIni)
            ->where('status', 'Terparkir')
            ->count();

        // Data tren kendaraan non-pegawai minggu ini
        $startOfWeek = Carbon::now()->startOfWeek(); // Senin
        $endOfWeek = Carbon::now()->endOfWeek();     // Minggu

        $labelsHariMingguIni = [];
        $dataMasukMingguIni = [];
        $dataKeluarMingguIni = [];

        for ($date = $startOfWeek->copy(); $date->lte($endOfWeek); $date->addDay()) {
            $labelsHariMingguIni[] = $date->format('D'); // Sen, Sel, Rab, ...
            $dataMasukMingguIni[] = Parkir::whereDate('waktu_masuk', $date->toDateString())->count();
            $dataKeluarMingguIni[] = Parkir::whereDate('waktu_keluar', $date->toDateString())->count();
        }

        return view('beranda', compact(
            'totalTerparkir',
            'totalKeluar',
            'totalPendapatan',
            'totalDenda',
            'kendaraanPegawaiTerparkir',
            'labelsHariMingguIni',
            'dataMasukMingguIni',
            'dataKeluarMingguIni'
        ));
    }
}
