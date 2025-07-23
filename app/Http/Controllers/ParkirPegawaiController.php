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
        $request->validate(['kode_member' => 'required|string']);

        $pegawai = Pegawai::where('kode_member', $request->kode_member)->first();
        if (!$pegawai) {
            return response()->json(['success' => false, 'message' => 'Data member pegawai tidak ditemukan.']);
        }

        $parkirAktif = ParkirPegawai::where('pegawai_id', $pegawai->id)
            ->where('status', 'Terparkir')
            ->latest('waktu_masuk')
            ->first();

        if ($parkirAktif) {
            // --- PROSES KELUAR ---
            $parkirAktif->update([
                'waktu_keluar' => now(),
                'status' => 'Keluar'
            ]);

            // REVISI RESPONSE JSON
            return response()->json([
                'success' => true,
                'data'    => [
                    'nama' => $pegawai->nama,
                    'aksi' => 'KELUAR'
                ]
            ]);
        } else {
            // --- PROSES MASUK ---
            ParkirPegawai::create([
                'pegawai_id' => $pegawai->id,
                'kode_member' => $pegawai->kode_member,
                'plat_kendaraan' => $pegawai->plat_kendaraan,
                'waktu_masuk' => now(),
                'status' => 'Terparkir'
            ]);

            // REVISI RESPONSE JSON
            return response()->json([
                'success' => true,
                'data'    => [
                    'nama' => $pegawai->nama,
                    'aksi' => 'MASUK'
                ]
            ]);
        }
    }


    public function laporan(Request $request)
    {
        $tanggalMulaiDefault = now()->startOfMonth()->format('Y-m-d');
        $tanggalSelesaiDefault = now()->format('Y-m-d');

        $tanggalMulai = $request->input('tanggal_mulai', $tanggalMulaiDefault);
        $tanggalSelesai = $request->input('tanggal_selesai', $tanggalSelesaiDefault);

        // Ambil input pegawai_id dari request
        $pegawaiId = $request->input('pegawai_id');

        $start = \Carbon\Carbon::parse($tanggalMulai)->startOfDay();
        $end = \Carbon\Carbon::parse($tanggalSelesai)->endOfDay();

        // Bangun query dasar
        $query = ParkirPegawai::with('pegawai')
            ->whereBetween('waktu_masuk', [$start, $end]);

        // ==========================================================
        //            TAMBAHKAN LOGIKA FILTER NAMA DI SINI
        // ==========================================================
        // Jika ada pegawai_id yang dipilih, tambahkan kondisi where ke query
        if ($pegawaiId) {
            $query->where('pegawai_id', $pegawaiId);
        }
        // ==========================================================

        // Eksekusi query
        $dataParkir = $query->orderBy('waktu_masuk', 'desc')->get();

        // Ambil daftar semua pegawai untuk ditampilkan di dropdown filter
        $pegawaiList = Pegawai::orderBy('nama')->get();

        return view('laporan.parkirpegawai.parkirpegawai', compact(
            'dataParkir',
            'tanggalMulai',
            'tanggalSelesai',
            'pegawaiList' // Kirim daftar pegawai ke view
        ));
    }

    public function cetakLaporan(Request $request)
    {
        // Ambil semua input filter dari request
        $tanggalMulai = $request->input('tanggal_mulai', now()->startOfMonth()->format('Y-m-d'));
        $tanggalSelesai = $request->input('tanggal_selesai', now()->format('Y-m-d'));
        $pegawaiId = $request->input('pegawai_id'); // Ambil ID pegawai yang difilter

        // Konversi tanggal menjadi objek Carbon dengan waktu yang akurat
        $start = \Carbon\Carbon::parse($tanggalMulai)->startOfDay();
        $end = \Carbon\Carbon::parse($tanggalSelesai)->endOfDay();

        // Bangun query dasar
        $query = ParkirPegawai::with('pegawai')
            ->whereBetween('waktu_masuk', [$start, $end]);

        // ==========================================================
        //            TAMBAHKAN LOGIKA FILTER NAMA DI SINI
        // ==========================================================
        // Jika ada pegawai_id yang dipilih, tambahkan kondisi where ke query
        if ($pegawaiId) {
            $query->where('pegawai_id', $pegawaiId);
        }
        // ==========================================================

        // Eksekusi query
        $dataParkir = $query->orderBy('waktu_masuk', 'desc')->get();

        // Ambil nama pegawai yang difilter (jika ada) untuk ditampilkan di judul PDF
        $namaPegawaiFilter = $pegawaiId ? \App\Models\Pegawai::find($pegawaiId)->nama : 'Semua Pegawai';

        // Load view PDF dengan data yang sudah benar
        $pdf = Pdf::loadView('laporan.parkirpegawai.parkirpegawai_pdf', compact(
            'dataParkir',
            'tanggalMulai',
            'tanggalSelesai',
            'namaPegawaiFilter' // Kirim nama pegawai ke view PDF
        ));

        // Memberi nama file yang lebih dinamis
        $fileName = 'laporan-parkir-pegawai-' . $tanggalMulai . '_sd_' . $tanggalSelesai . '.pdf';
        return $pdf->stream($fileName);
    }
}
