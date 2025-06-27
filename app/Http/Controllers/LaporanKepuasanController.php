<?php

namespace App\Http\Controllers;

use App\Models\KuesionerPertanyaan;
use App\Models\PenilaianJawaban;
use App\Models\PenilaianKepuasan;
use App\Models\Tuser;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF; // Pastikan Anda sudah menginstal barryvdh/laravel-dompdf

class LaporanKepuasanController extends Controller
{
    /**
     * Menampilkan halaman utama laporan kepuasan.
     */
    public function index(Request $request)
    {
        // Panggil method private untuk mengambil semua data yang sudah diolah
        $data = $this->getSatisfactionData($request);

        // Kirim semua data ke view
        return view('laporan.kepuasan.index', $data);
    }

    /**
     * Menghasilkan dan menampilkan laporan dalam format PDF.
     */
    public function cetakPDF(Request $request)
    {
        // Panggil method private yang sama untuk mendapatkan data yang konsisten
        $data = $this->getSatisfactionData($request);

        // Load view PDF dengan data yang sama
        $pdf = FacadePdf::loadView('laporan.kepuasan.kepuasan_pdf', $data);

        // Atur nama file PDF yang akan di-download
        $fileName = 'Laporan_Kepuasan_Periode_' . $data['startDate']->format('d-m-Y') . '_-_' . $data['endDate']->format('d-m-Y') . '.pdf';

        // Tampilkan PDF di browser
        return $pdf->stream($fileName);
    }



    private function getSatisfactionData(Request $request)
    {
        // --- 1. Logika Filter Tanggal ---
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : now()->subDays(30);
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : now();
        $startDate = $startDate->startOfDay();
        $endDate = $endDate->endOfDay();

        // --- 2. Query Data Utama Berdasarkan Rentang Tanggal ---
        $penilaianIds = PenilaianKepuasan::whereBetween('created_at', [$startDate, $endDate])->pluck('id');

        // --- 3. Hitung Statistik Umum ---
        $totalPenilaian = $penilaianIds->count();
        $avgRatingFasilitas = PenilaianJawaban::whereIn('penilaian_kepuasan_id', $penilaianIds)
            ->whereHas('pertanyaan', fn($q) => $q->where('kategori', 'fasilitas'))->avg('jawaban_rating');
        $avgRatingPetugas = PenilaianJawaban::whereIn('penilaian_kepuasan_id', $penilaianIds)
            ->whereHas('pertanyaan', fn($q) => $q->where('kategori', 'petugas'))->avg('jawaban_rating');

        // --- 4. Analisis Kinerja Petugas ---
        $kinerjaPetugas = Tuser::query()
            ->whereIn('role', ['admin', 'super_admin'])
            // ======================================================
            ->whereHas('penilaianDiterima', fn($q) => $q->whereIn('id', $penilaianIds))
            ->with('staff')
            ->withCount(['penilaianDiterima as jumlah_penilaian' => fn($q) => $q->whereIn('id', $penilaianIds)])
            ->addSelect([
                'avg_rating' => PenilaianJawaban::query()
                    ->selectRaw('avg(jawaban_rating)')
                    ->join('penilaian_kepuasan', 'penilaian_jawaban.penilaian_kepuasan_id', '=', 'penilaian_kepuasan.id')
                    ->join('kuesioner_pertanyaan', 'penilaian_jawaban.pertanyaan_id', '=', 'kuesioner_pertanyaan.id')
                    ->whereColumn('penilaian_kepuasan.tuser_id', 'tuser.id')
                    ->whereIn('penilaian_kepuasan.id', $penilaianIds)
                    ->where('kuesioner_pertanyaan.kategori', 'petugas')
            ])
            ->orderByDesc('avg_rating')
            ->get();

        // --- 5. Analisis per Pertanyaan ---
        $analisisPertanyaan = KuesionerPertanyaan::where('status', 'aktif')
            ->withAvg(['jawaban as avg_rating' => fn($q) => $q->whereIn('penilaian_kepuasan_id', $penilaianIds)], 'jawaban_rating')
            ->orderBy('kategori')->orderBy('urutan')
            ->get();

        // --- 6. Ambil Komentar Terbaru ---
        $komentarTerbaru = PenilaianKepuasan::with('petugas.staff')
            ->whereIn('id', $penilaianIds)
            ->where(fn($q) => $q->whereNotNull('komentar_fasilitas')->orWhere('komentar_fasilitas', '!=', '')
                ->orWhereNotNull('komentar_petugas')->orWhere('komentar_petugas', '!=', ''))
            ->latest()->take(15)->get();

        // --- 7. Kembalikan semua data dalam bentuk array ---
        return [
            'totalPenilaian' => $totalPenilaian,
            'avgRatingFasilitas' => $avgRatingFasilitas,
            'avgRatingPetugas' => $avgRatingPetugas,
            'kinerjaPetugas' => $kinerjaPetugas,
            'analisisPertanyaan' => $analisisPertanyaan,
            'komentarTerbaru' => $komentarTerbaru,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];
    }
}
