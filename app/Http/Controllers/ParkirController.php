<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Denda;
use App\Models\Tarif;
use App\Models\Parkir;
use App\Models\Pegawai;
use App\Models\Kategori;
use App\Models\SlotParkir;
use Illuminate\Http\Request;
use App\Models\ParkirPegawai;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        // Eager load relasi 'kategori' pada model 'Tarif'
        $tarif = Tarif::with('kategori')->get();

        // Ambil data parkir
        $parkir = Parkir::with('tarif', 'user')
            ->where('status', 'Terparkir')
            ->orderBy('waktu_masuk', 'desc')
            ->get();

        // Generate kode_parkir
        $last = Parkir::orderBy('id', 'desc')->first();
        $nextNumber = $last ? ((int)substr($last->kode_parkir, 2)) + 1 : 1;
        $kodeParkir = 'KP' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // Waktu sekarang
        $jam = \Carbon\Carbon::now('Asia/Makassar')->format('H:i');

        // Ambil data slot parkir
        $slots = SlotParkir::with('kategori')->withCount(['parkir as terpakai' => function ($q) {
            $q->where('status', 'Terparkir');
        }])->get();

        // Ubah koleksi slot menjadi array JSON yang siap digunakan di JavaScript
        $allSlotsData = $slots->map(function ($item) {
            return [
                'id' => $item->id,
                'nama_slot' => $item->nama_slot,
                'kapasitas' => $item->kapasitas,
                'terpakai' => $item->terpakai,
                'kategori_id' => $item->kategori->id, // Mengambil ID dari relasi kategori
            ];
        })->values()->toArray();

        return view('manajemen-parkir.tampil', compact('tarif', 'parkir', 'jam', 'kodeParkir', 'allSlotsData', 'slots'));
    }


    public function submit(Request $request)
    {
        // Validasi input
        $request->validate([
            'plat_kendaraan' => 'required|string|max:255',
            'jenis_tarif' => 'required|exists:tarif,id',
            'user_id' => 'required|exists:tuser,id',
        ]);

        // Ambil data tarif beserta kategorinya
        $tarif = Tarif::with('kategori')->findOrFail($request->jenis_tarif);

        // Cari slot parkir kosong yang sesuai dengan kategori tarif
        // 1. Hitung jumlah kendaraan terparkir di setiap slot
        // 2. Filter slot yang terpakai < kapasitas
        $slotTersedia = SlotParkir::withCount(['parkir as terpakai' => function ($q) {
            $q->where('status', 'Terparkir');
        }])
            ->where('kategori_id', $tarif->kategori_id)
            ->havingRaw('kapasitas > terpakai')
            ->first();

        // Validasi ketersediaan slot: Jika tidak ada slot yang cocok dan kosong, berikan pesan error.
        if (!$slotTersedia) {
            return back()->with('error', 'Tidak ada slot parkir yang tersedia untuk jenis kendaraan ini.');
        }

        DB::beginTransaction();
        try {
            $last = Parkir::latest('id')->lockForUpdate()->first();
            $nextNumber = $last ? ((int)substr($last->kode_parkir, 2)) + 1 : 1;
            $kodeParkir = 'KP' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            // Simpan data parkir
            $parkirBaru = Parkir::create([
                'kode_parkir' => $kodeParkir,
                'plat_kendaraan' => $request->plat_kendaraan,
                'tarif_id' => $request->jenis_tarif,
                'user_id' => $request->user_id,
                'slot_parkir_id' => $slotTersedia->id, // Langsung mengisi slot_id dengan yang otomatis terpilih
                'waktu_masuk' => now(),
                'status' => 'Terparkir',
            ]);

            DB::commit();

            return redirect()->route('manajemen-parkir.cetak-parkir', ['id' => $parkirBaru->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses data masuk: ' . $e->getMessage());
        }
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

        $hasilKalkulasi = $this->hitungBiayaDanDenda($parkir, $waktuKeluar);

        $this->updateStatusParkir($parkir, $waktuKeluar, $hasilKalkulasi['durasiMenit']);


        if ($hasilKalkulasi['denda'] > 0) {
            $this->simpanDenda($parkir, $hasilKalkulasi['denda']);
        }

        return redirect()->route('parkir.cetak-struk', ['id' => $parkir->id]);
    }


    private function hitungBiayaDanDenda(Parkir $parkir, Carbon $waktuKeluar): array
    {
        $durasiMenit = $parkir->waktu_masuk->diffInMinutes($waktuKeluar);
        $durasiJam = ceil($durasiMenit / 60);
        $dendaTotal = 0;

        // Cek jika jenis tarif INAP dan durasi melebihi 48 jam
        if (strtoupper($parkir->tarif->jenis_tarif ?? '') === 'INAP') {
            $batasJam = 48;

            if ($durasiJam > $batasJam) {
                $jamTerlambat = $durasiJam - $batasJam;
                $kategori = strtoupper($parkir->tarif->kategori->nama_kategori ?? '');
                $tarifPerJam = ($kategori === 'RODA 2') ? 10000 : 20000;
                $dendaTotal = $jamTerlambat * $tarifPerJam;
            }
        }

        return [
            'durasiMenit' => $durasiMenit,
            'denda' => $dendaTotal
        ];
    }


    private function updateStatusParkir(Parkir $parkir, Carbon $waktuKeluar, int $durasiMenit): void
    {
        $parkir->waktu_keluar = $waktuKeluar;
        $parkir->status = Parkir::STATUS_KELUAR;
        $parkir->durasi = $durasiMenit;
        $parkir->save();
    }


    private function simpanDenda(Parkir $parkir, float $nominalDenda): void
    {
        if (method_exists($parkir, 'denda')) {
            $parkir->denda()->updateOrCreate(
                ['parkir_id' => $parkir->id],
                [
                    'plat_kendaraan' => $parkir->plat_kendaraan,
                    'tanggal' => now()->toDateString(),
                    'nominal' => $nominalDenda,
                    'status' => 'Belum Dibayar', // Asumsi status default
                ]
            );
        }
    }


    public function scanKeluar()
    {
        return view('manajemen-parkir.scan-keluar');
    }

    public function prosesScanKeluar(Request $request)
    {
        // --- Bagian validasi awal Anda sudah sangat baik, kita pertahankan ---
        $decodedText = $request->input('decodedText');

        if (!$decodedText) {
            return response()->json([
                'success' => false,
                'message' => 'Data barcode tidak terbaca.',
            ]);
        }

        $parkir = Parkir::with('tarif.kategori')
            ->where('kode_parkir', $decodedText)
            ->whereNull('waktu_keluar')
            ->latest()
            ->first();

        if (!$parkir) {
            return response()->json([
                'success' => false,
                'message' => 'Data parkir tidak ditemukan atau kendaraan sudah keluar.',
            ]);
        }

        $waktuKeluar = now(); // Gunakan waktu saat ini untuk scan

        if ($waktuKeluar->lt($parkir->waktu_masuk)) {
            return response()->json([
                'success' => false,
                'message' => 'Waktu keluar tidak boleh sebelum waktu masuk. Periksa jam server.',
            ]);
        }

        // --- Bagian utama proses keluar kendaraan ---

        // 1. Panggil helper untuk menghitung biaya dan denda
        $hasilKalkulasi = $this->hitungBiayaDanDenda($parkir, $waktuKeluar);

        // 2. Panggil helper untuk update status parkir & slot
        $this->updateStatusParkir($parkir, $waktuKeluar, $hasilKalkulasi['durasiMenit']);

        // 3. Panggil helper untuk simpan denda HANYA JIKA ada denda
        if ($hasilKalkulasi['denda'] > 0) {
            $this->simpanDenda($parkir, $hasilKalkulasi['denda']);
        }

        // 4. Arahkan ke halaman cetak struk
        $cetakUrl = route('parkir.cetak-struk', ['id' => $parkir->id]);

        // 5. Kirim response JSON yang berisi URL untuk mencetak struk
        return response()->json([
            'success' => true,
            'message' => $hasilKalkulasi['denda'] > 0
                ? 'Kendaraan terkena denda. Silakan cetak struk.'
                : 'Kendaraan berhasil keluar. Silakan cetak struk.',
            'data' => [
                'plat_kendaraan' => $parkir->plat_kendaraan,
                'denda' => $hasilKalkulasi['denda'],
                'cetak_url' => $cetakUrl // URL ini yang akan dibuka oleh JavaScript di frontend
            ]
        ]);
    }



    public function cetakParkir($id)
    {
        $parkir = Parkir::with('tarif')->findOrFail($id);

        $qrCodeData = base64_encode(QrCode::size(100)->generate($parkir->kode_parkir));
        $qrCode = 'data:image/svg+xml;base64,' . $qrCodeData;

        $pdf = Pdf::loadView('manajemen-parkir.cetak-parkir', compact('parkir', 'qrCode')) // Tambahkan 'qrCode' ke compact
            ->setPaper([0, 0, 226.77, 453.54], 'portrait'); // Ini adalah 58mm x 160mm, biasanya sudah cukup

        return $pdf->stream('Struk_' . $parkir->plat_kendaraan . '.pdf');
    }


    public function cetakStruk($id)
    {
        // 1. Ambil semua data yang relevan dalam satu query, ini sudah benar
        $parkir = Parkir::with(['tarif.kategori', 'denda', 'user.staff'])
            ->findOrFail($id);

        // 2. Siapkan semua variabel biaya, ini juga sudah benar
        $tarif = $parkir->tarif->tarif ?? 0;
        $denda = $parkir->denda->nominal ?? 0;
        $total = $tarif + $denda;

        // --- TAMBAHKAN LOGIKA BARU DI SINI ---
        // 3. Buat URL feedback yang unik
        $feedbackUrl = route('feedback.dynamic.show', ['kode_parkir' => $parkir->kode_parkir]);

        // 1. Generate QR Code sebagai SVG (format default yang tidak butuh extension)
        $svg = QrCode::size(100)->generate($feedbackUrl);

        // 2. Ubah SVG tersebut menjadi Data URL Base64 yang bisa langsung ditempel di <img>
        $qrCode = 'data:image/svg+xml;base64,' . base64_encode($svg);


        // 5. Gabungkan SEMUA data untuk dikirim ke view
        $dataToView = compact('parkir', 'tarif', 'denda', 'total', 'feedbackUrl', 'qrCode');

        // Cek jika ingin langsung generate PDF, misalnya pakai query string ?pdf=1
        $pdf = Pdf::loadView('manajemen-parkir.struk', $dataToView)
            ->setPaper([0, 0, 226.77, 453.54], 'portrait'); // 58mm x 160mm

        // Default tampilan HTML biasa
        return $pdf->stream('Struk_' . $parkir->plat_kendaraan . '.pdf');
    }



    public function laporan(Request $request)
    {
        // Atur rentang tanggal default ke awal bulan ini hingga hari ini
        $tanggalMulaiDefault = now()->startOfMonth()->format('Y-m-d');
        $tanggalSelesaiDefault = now()->format('Y-m-d');

        // Ambil semua input filter dari request
        $tanggalMulai = $request->input('tanggal_mulai', $tanggalMulaiDefault);
        $tanggalSelesai = $request->input('tanggal_selesai', $tanggalSelesaiDefault);
        $status = $request->input('status'); // Ambil input status

        // Konversi tanggal ke Carbon untuk query yang akurat
        $start = \Carbon\Carbon::parse($tanggalMulai)->startOfDay();
        $end = \Carbon\Carbon::parse($tanggalSelesai)->endOfDay();

        // Bangun query dasar dengan semua relasi yang dibutuhkan
        $query = Parkir::with(['user.staff', 'tarif.kategori', 'denda'])
            ->whereBetween('waktu_masuk', [$start, $end]);

        // Tambahkan filter status jika ada
        $query->when($status, function ($q) use ($status) {
            return $q->where('status', $status);
        });
        // ==========================================================

        // Eksekusi query dengan urutan
        $dataParkir = $query->orderBy('waktu_masuk', 'desc')->get();

        return view('laporan.parkir.parkir', compact(
            'dataParkir',
            'tanggalMulai',
            'tanggalSelesai'
            // Variabel 'status' tidak perlu dikirim ke view karena sudah ada di 'request()'
        ));
    }

    public function cetakLaporan(Request $request)
    {
        // Gunakan logika tanggal default yang konsisten
        $tanggalMulaiDefault = now()->startOfMonth()->format('Y-m-d');
        $tanggalSelesaiDefault = now()->format('Y-m-d');

        $tanggalMulai = $request->input('tanggal_mulai', $tanggalMulaiDefault);
        $tanggalSelesai = $request->input('tanggal_selesai', $tanggalSelesaiDefault);
        $status = $request->input('status', null);

        // Konversi ke objek Carbon untuk query yang akurat
        try {
            $start = Carbon::parse($tanggalMulai)->startOfDay();
            $end = Carbon::parse($tanggalSelesai)->endOfDay();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => 'Format tanggal tidak valid.']);
        }


        $query = Parkir::with(['tarif.kategori', 'denda', 'user.staff'])
            ->whereBetween('waktu_masuk', [$start, $end]);

        if ($status) {
            $query->where('status', $status);
        }

        // Eksekusi query
        $dataParkir = $query->orderBy('waktu_masuk', 'desc')->get();
        // ==========================================================

        // Generate PDF dengan view laporan
        $pdf = PDF::loadView('laporan.parkir.parkir_pdf', compact(
            'dataParkir',
            'tanggalMulai',
            'tanggalSelesai',
            'status'
        ));

        $fileName = 'laporan-parkir-' . $tanggalMulai . '_sd_' . $tanggalSelesai . '.pdf';
        return $pdf->stream($fileName);
    }


    public function laporanPendapatan(Request $request)
    {
        // Ambil input filter tanggal mulai dan selesai
        $tanggalMulai = $request->input('tanggal_mulai')
            ? Carbon::parse($request->input('tanggal_mulai'))
            : Carbon::today();

        $tanggalSelesai = $request->input('tanggal_selesai')
            ? Carbon::parse($request->input('tanggal_selesai'))
            : Carbon::today();

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

        // Ambil data parkir sesuai filter
        $query = Parkir::with(['tarif', 'denda'])
            ->where('status', 'Keluar')
            ->whereBetween('waktu_keluar', [$tanggalMulai->startOfDay(), $tanggalSelesai->endOfDay()]);

        if ($jenisTarif) {
            $query->whereHas('tarif', function ($q) use ($jenisTarif) {
                $q->where('jenis_tarif', $jenisTarif);
            });
        }

        $dataParkir = $query->get();

        // Hitung tarif parkir
        $pendapatanMurni = $dataParkir->sum(fn($item) => $item->tarif->tarif ?? 0);

        // Hitung total denda yang sudah dibayar
        $pendapatanDenda = Denda::where('status', 'Sudah Dibayar')
            ->whereBetween('tanggal', [$tanggalMulai->startOfDay(), $tanggalSelesai->endOfDay()])
            ->when($jenisTarif, function ($q) use ($jenisTarif) {
                $q->whereHas('parkir.tarif', function ($q2) use ($jenisTarif) {
                    $q2->where('jenis_tarif', $jenisTarif);
                });
            })
            ->sum('nominal');

        // Total pendapatan (tarif + denda)
        $totalPendapatan = $pendapatanMurni + $pendapatanDenda;

        // Load ke PDF view
        $pdf = PDF::loadView('laporan.pendapatan.pendapatan_pdf', compact(
            'dataParkir',
            'tanggalMulai',
            'tanggalSelesai',
            'jenisTarif',
            'pendapatanMurni',
            'pendapatanDenda',
            'totalPendapatan'
        ));

        return $pdf->stream('laporan-pendapatan-' . $tanggalMulai->format('Y-m-d') . '-sampai-' . $tanggalSelesai->format('Y-m-d') . '-jenis-tarif-' . ($jenisTarif ?? 'semua') . '.pdf');
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
        $kendaraanPegawaiTerparkir = ParkirPegawai::whereDate('waktu_masuk', $tanggalHariIni)
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

        // --- Tambahan untuk Grafik Bulanan ---
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $labelsBulanIni = [];
        $dataMasukBulanIni = [];
        $dataKeluarBulanIni = [];

        for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
            $labelsBulanIni[] = $date->format('j M'); // Format: '1 Agt', '2 Agt', dst.
            $dataMasukBulanIni[] = Parkir::whereDate('waktu_masuk', $date->toDateString())->count();
            $dataKeluarBulanIni[] = Parkir::whereDate('waktu_keluar', $date->toDateString())->count();
        }

        // --- Kirim data ke view ---
        return view('beranda', compact(
            'totalTerparkir',
            'totalKeluar',
            'totalPendapatan',
            'totalDenda',
            'kendaraanPegawaiTerparkir',
            'labelsHariMingguIni',
            'dataMasukMingguIni',
            'dataKeluarMingguIni',
            'labelsBulanIni',      // Tambahkan variabel baru ini
            'dataMasukBulanIni',   // Tambahkan variabel baru ini
            'dataKeluarBulanIni'   // Opsional: jika Anda ingin menampilkan tren keluar juga
        ));
    }
}
