<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Models\ParkirPegawai;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ParkirPegawaiController extends Controller
{
    public function tampil()
    {
        return view('manajemen-parkirpegawai.scan');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'kode_member' => 'required|string',
        ]);

        // Cari pegawai berdasarkan kode_member
        $pegawai = Pegawai::where('kode_member', $request->kode_member)->first();

        if (!$pegawai) {
            return response()->json([
                'success' => false,
                'message' => 'Pegawai dengan kode member ini tidak ditemukan.'
            ], 404);
        }

        ParkirPegawai::create([
            'kode_member' => $pegawai->kode_member,
            'plat_kendaraan' => $pegawai->plat_kendaraan,
            'tanggal' => Carbon::now('Asia/Makassar')->format('Y-m-d'),
            'jam_masuk' => Carbon::now('Asia/Makassar')->format('H:i'),
            'pegawai_id' => $pegawai->id,
            'status' => ParkirPegawai::STATUS_TERPARKIR,
        ]);

        return response()->json([
            'success' => true,
            'message' => $pegawai->plat_kendaraan
        ]);
    }

    public function laporan(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai', now()->today()->toDateString());
        $tanggalSelesai = $request->input('tanggal_selesai', now()->toDateString());

        $dataParkir = ParkirPegawai::with('pegawai')
            ->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])
            ->get();

        return view('laporan.parkirpegawai.parkirpegawai', compact('dataParkir', 'tanggalMulai', 'tanggalSelesai'));
    }

    public function cetakLaporan(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai', now()->startOfMonth()->toDateString());
        $tanggalSelesai = $request->input('tanggal_selesai', now()->toDateString());

        $dataParkir = ParkirPegawai::with('pegawai')
            ->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])
            ->get();

        $pdf = Pdf::loadView('laporan.parkirpegawai.parkirpegawai_pdf', compact('dataParkir', 'tanggalMulai', 'tanggalSelesai'));
        return $pdf->stream('laporan_parkir_pegawai.pdf');
    }
}
