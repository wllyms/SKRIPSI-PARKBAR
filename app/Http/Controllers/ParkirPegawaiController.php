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
            'plat_kendaraan' => 'required|string',
        ]);

        $pegawai = Pegawai::where('plat_kendaraan', $request->plat_kendaraan)->first();

        if (!$pegawai) {
            return response()->json([
                'success' => false,
                'message' => 'Pegawai dengan plat kendaraan ini tidak ditemukan.'
            ], 404);
        }

        ParkirPegawai::create([
            'plat_kendaraan' => $pegawai->plat_kendaraan,
            'tanggal' => Carbon::now('Asia/Makassar')->format('Y-m-d'),
            'jam_masuk' => Carbon::now('Asia/Makassar')->format('H:i'),
            'pegawai_id' => $pegawai->id,
            'status' => ParkirPegawai::STATUS_TERPARKIR,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Parkir pegawai berhasil dicatat.'
        ]);
    }

    public function laporan(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai', now()->startOfMonth()->toDateString());
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
