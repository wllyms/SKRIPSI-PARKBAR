<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Denda;
use App\Models\Parkir;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DendaController extends Controller
{
    public function tampil(Request $request)
    {
        // Ambil filter dari query atau default
        $tanggalMulai = $request->input('tanggal_mulai', date('Y-m-01'));
        $tanggalSelesai = $request->input('tanggal_selesai', date('Y-m-d'));
        $status = $request->input('status');

        // Query denda dengan relasi parkir, tarif, user, staff
        $query = Denda::with(['parkir.tarif', 'parkir.user.staff'])
            ->whereHas('parkir', function ($q) use ($tanggalMulai, $tanggalSelesai) {
                $q->whereBetween('waktu_masuk', ["$tanggalMulai 00:00:00", "$tanggalSelesai 23:59:59"]);
            });

        if ($status) {
            $query->where('status', $status);
        }

        $dataDenda = $query->orderByDesc('created_at')->get();

        return view('manajemen-denda.tampil', compact('dataDenda', 'tanggalMulai', 'tanggalSelesai', 'status'));
    }




    public function bayar($id)
    {
        $denda = Denda::findOrFail($id);

        if ($denda->status == 'Sudah Dibayar') {
            return redirect()->route('manajemen-denda.tampil')
                ->with('warning', 'Denda ini sudah dibayar.');
        }

        $denda->update([
            'status' => 'Sudah Dibayar',
        ]);

        return redirect()->route('manajemen-denda.tampil')
            ->with('success', 'Denda berhasil dibayar.');
    }

    public function laporanDenda(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai ?? Carbon::now()->today()->format('Y-m-d');
        $tanggalSelesai = $request->tanggal_selesai ?? Carbon::now()->format('Y-m-d');

        $query = Denda::with(['parkir.user.staff', 'parkir.tarif.kategori'])
            ->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $dataDenda = $query->get();

        return view('laporan.denda.denda', compact('dataDenda', 'tanggalMulai', 'tanggalSelesai'));
    }

    public function cetak(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');
        $status = $request->input('status');

        $query = Denda::query();

        if ($tanggalMulai && $tanggalSelesai) {
            $query->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $dataDenda = $query->orderBy('tanggal', 'desc')->get();

        $pdf = Pdf::loadView('laporan.denda.denda_pdf', [
            'dataDenda' => $dataDenda,
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
            'status' => $status,
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('laporan.denda_pdf');
    }
}
