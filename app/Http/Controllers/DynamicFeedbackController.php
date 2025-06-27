<?php

namespace App\Http\Controllers;

use App\Models\Parkir;
use Illuminate\Http\Request;
use App\Models\PenilaianKepuasan;
use Illuminate\Support\Facades\DB;
use App\Models\KuesionerPertanyaan;
use Illuminate\Support\Facades\Log;

class DynamicFeedbackController extends Controller
{
    public function tampilkanForm($kode_parkir)
    {
        try {
            // Ambil data parkir beserta relasi ke user dan staffnya
            $parkir = Parkir::with('user.staff', 'penilaian')->where('kode_parkir', $kode_parkir)->firstOrFail();

            // Cek apakah sudah pernah memberikan feedback
            if ($parkir->penilaian) {
                return view('feedback.terima_kasih')->with('message', 'Terima kasih, Anda sudah pernah memberikan penilaian untuk sesi parkir ini.');
            }

            // Ambil semua pertanyaan aktif dari database
            $pertanyaan = KuesionerPertanyaan::where('status', 'aktif')->orderBy('urutan')->get();
            $pertanyaanTerkelompok = $pertanyaan->groupBy('kategori');

            // Ambil nama petugas dari relasi
            $namaPetugas = $parkir->user && $parkir->user->staff ? $parkir->user->staff->nama : 'Petugas';

            // Mengembalikan view dengan data, mirip dengan method 'tampil' Anda
            return view('feedback.dynamic_form', compact('parkir', 'namaPetugas', 'pertanyaanTerkelompok'));
        } catch (\Exception $e) {
            Log::error('Gagal menampilkan form feedback: ' . $e->getMessage());
            // Jika kode parkir tidak valid atau ada error lain, tampilkan halaman error
            abort(404, 'Halaman tidak ditemukan atau terjadi kesalahan.');
        }
    }
 
    /**
     * Menyimpan data penilaian dari form.
     * Disesuaikan dengan nama method 'submit' dari contoh Anda, saya beri nama 'simpanPenilaian'.
     */
    public function simpanPenilaian(Request $request)
    {
        // PENTING: Menambahkan Validasi untuk keamanan data
        // Meskipun di contoh Anda tidak ada, ini adalah praktik terbaik yang sangat disarankan.
        $request->validate([
            'parkir_id' => 'required|exists:parkir,id|unique:penilaian_kepuasan,parkir_id',
            'tuser_id' => 'required|exists:tuser,id',
            'ratings' => 'required|array',
            'ratings.*' => 'required|integer|min:1|max:5',
            'komentar_fasilitas' => 'nullable|string|max:1000',
            'komentar_petugas' => 'nullable|string|max:1000',
        ]);

        // Menggunakan try-catch seperti pada method update/delete Anda
        try {
            DB::transaction(function () use ($request) {
                // 1. Buat induk penilaian
                $penilaian = PenilaianKepuasan::create([
                    'parkir_id' => $request->parkir_id,
                    'tuser_id' => $request->tuser_id,
                    'komentar_fasilitas' => $request->komentar_fasilitas,
                    'komentar_petugas' => $request->komentar_petugas,
                ]);

                // 2. Simpan setiap jawaban rating
                foreach ($request->ratings as $pertanyaan_id => $rating) {
                    $penilaian->jawaban()->create([
                        'pertanyaan_id' => $pertanyaan_id,
                        'jawaban_rating' => $rating,
                    ]);
                }
            });
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan penilaian: ' . $e->getMessage());
            // Kembali ke halaman sebelumnya dengan pesan error, mirip pola Anda
            return back()->withInput()->with('error', '<strong>Gagal</strong> menyimpan penilaian. Terjadi kesalahan pada server.');
        }

        // Tampilkan halaman terima kasih. Ini lebih cocok daripada redirect untuk form publik.
        return view('feedback.terima_kasih')->with('message', '<strong>Terima kasih banyak!</strong> Masukan Anda telah berhasil kami simpan.');
    }
}
