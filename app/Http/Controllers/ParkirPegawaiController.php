<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Models\ParkirPegawai;
use Barryvdh\DomPDF\Facade\Pdf; // Saya tambahkan use statement untuk PDF

class ParkirPegawaiController extends Controller
{

    public function tampil()
    {
        // Ganti nama view agar konsisten dengan file Anda
        return view('manajemen-parkirpegawai.scan');
    }


    public function submit(Request $request)
    {
        // Validasi input dari scanner
        $request->validate(['kode_member' => 'required|string']);

        // 1. Cari data pegawai berdasarkan kode member yang di-scan
        $pegawai = Pegawai::where('kode_member', $request->kode_member)->first();

        if (!$pegawai) {
            return response()->json(['success' => false, 'message' => 'Data member pegawai tidak ditemukan.']);
        }

        // 2. Cek apakah ada catatan parkir yang masih berstatus 'Terparkir' untuk pegawai ini
        $parkirAktif = ParkirPegawai::where('pegawai_id', $pegawai->id)
            ->where('status', 'Terparkir')
            ->latest('waktu_masuk')
            ->first();

        if ($parkirAktif) {



            $parkirAktif->update([
                'waktu_keluar' => now(), // Menggunakan datetime, bukan jam terpisah
                'status' => 'Keluar'
            ]);

            return response()->json([
                'success' => true,
                'message' => "Selamat Jalan! Pegawai: {$pegawai->nama} berhasil KELUAR."
            ]);
        } else {

            ParkirPegawai::create([
                'pegawai_id' => $pegawai->id,
                'kode_member' => $pegawai->kode_member,
                'plat_kendaraan' => $pegawai->plat_kendaraan,
                'waktu_masuk' => now(), // Menggunakan datetime
                'status' => 'Terparkir'
            ]);

            return response()->json([
                'success' => true,
                'message' => "Selamat Datang! Pegawai: {$pegawai->nama} berhasil MASUK."
            ]);
        }
    }


    public function laporan(Request $request)
    {

        $tanggalMulaiDefault = now()->startOfMonth()->format('Y-m-d');
        $tanggalSelesaiDefault = now()->format('Y-m-d');


        $tanggalMulai = $request->input('tanggal_mulai', $tanggalMulaiDefault);
        $tanggalSelesai = $request->input('tanggal_selesai', $tanggalSelesaiDefault);

        $start = Carbon::parse($tanggalMulai)->startOfDay();
        $end = Carbon::parse($tanggalSelesai)->endOfDay();


        $dataParkir = ParkirPegawai::with('pegawai')
            ->whereBetween('waktu_masuk', [$start, $end])
            ->orderBy('waktu_masuk', 'desc')
            ->get();

        return view('laporan.parkirpegawai.parkirpegawai', compact(
            'dataParkir',
            'tanggalMulai',
            'tanggalSelesai'
        ));
    }

    public function cetakLaporan(Request $request)
    {
        // Ambil input tanggal, dengan default awal bulan hingga hari ini
        $tanggalMulai = $request->input('tanggal_mulai', now()->startOfMonth()->format('Y-m-d'));
        $tanggalSelesai = $request->input('tanggal_selesai', now()->format('Y-m-d'));

        // --- PENYEMPURNAAN DI SINI ---
        // Konversi tanggal menjadi objek Carbon dengan waktu yang akurat
        $start = \Carbon\Carbon::parse($tanggalMulai)->startOfDay(); // Contoh: 2025-06-29 00:00:00
        $end = \Carbon\Carbon::parse($tanggalSelesai)->endOfDay();   // Contoh: 2025-06-29 23:59:59

        $dataParkir = ParkirPegawai::with('pegawai')
            // Gunakan variabel $start dan $end yang sudah akurat
            ->whereBetween('waktu_masuk', [$start, $end])
            // Tambahkan order by agar laporan selalu urut
            ->orderBy('waktu_masuk', 'desc')
            ->get();

        $pdf = Pdf::loadView('laporan.parkirpegawai.parkirpegawai_pdf', compact(
            'dataParkir',
            'tanggalMulai',
            'tanggalSelesai'
        ));

        // Memberi nama file yang lebih dinamis
        $fileName = 'laporan-parkir-pegawai-' . $tanggalMulai . '_sd_' . $tanggalSelesai . '.pdf';

        return $pdf->stream($fileName);
    }
}
