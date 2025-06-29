<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\LaporanPengunjung;
use Illuminate\Support\Facades\Validator;

class LaporanPengunjungController extends Controller
{
    public function tampil()
    {
        $laporan = LaporanPengunjung::with('user.staff')->get();
        return view('manajemen-pengaduan.tampil', compact('laporan'));
    }

    public function submit(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'waktu_lapor' => 'required|date',
            'no_telp' => 'required|string|max:20',
            'keterangan' => 'required|string',
            'user_id' => 'required|exists:tuser,id',
        ]);

        // Simpan ke database
        $laporan = new LaporanPengunjung();
        $laporan->user_id = $request->user_id;
        $laporan->nama = $request->nama;
        $laporan->waktu_lapor = $request->waktu_lapor;
        $laporan->no_telp = $request->no_telp;
        $laporan->keterangan = $request->keterangan;
        $laporan->status = 'Diproses';
        $laporan->save();

        // Kembali dengan pesan sukses
        return back()->with('success', 'Pengaduan Pengunjung Berhasil Ditambahkan');
    }

    public function update(Request $request, $id)
    {
        // Cari data laporan berdasarkan id
        $laporan = LaporanPengunjung::findOrFail($id);

        // Validasi input data
        $validator = Validator::make($request->all(), [
            'nama'        => 'required|string|max:255',
            'waktu_lapor' => 'required|date',
            'no_telp'     => 'nullable|string|max:20',
            'keterangan'  => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update data laporan
        $laporan->nama = $request->input('nama');
        $laporan->waktu_lapor = $request->input('waktu_lapor');
        $laporan->no_telp = $request->input('no_telp');
        $laporan->keterangan = $request->input('keterangan');

        $laporan->save();

        // Redirect balik dengan pesan sukses
        return redirect()->route('manajemen-pengaduan.tampil')->with('success', 'Pengaduan pengunjung berhasil diperbarui.');
    }

    public function selesaikan($id)
    {
        try {
            $laporan = LaporanPengunjung::findOrFail($id);
            $laporan->status = 'Selesai';
            $laporan->save();

            return redirect()->route('manajemen-pengaduan.tampil')->with('success', 'Pengaduan berhasil ditandai sebagai <strong>Selesai</strong>.');
        } catch (\Exception $e) {
            return redirect()->route('manajemen-pengaduan.tampil')->with('error', '<strong>Gagal</strong> mengubah status pengaduan.');
        }
    }

    public function delete($id)
    {
        // Cari data laporan berdasarkan id
        $laporan = LaporanPengunjung::find($id);

        if (!$laporan) {
            return back()->with('error', 'Laporan tidak ditemukan.');
        }

        // Hapus data laporan
        $laporan->delete();

        return back()->with('success', 'Laporan berhasil dihapus.');
    }

    public function laporan(Request $request)
    {

        $tanggalMulai = $request->tanggal_mulai ?? now()->today()->toDateString();
        $tanggalSelesai = $request->tanggal_selesai ?? now()->toDateString();

        $laporan = LaporanPengunjung::whereBetween('waktu_lapor', [$tanggalMulai . ' 00:00:00', $tanggalSelesai . ' 23:59:59'])
            ->orderBy('waktu_lapor', 'desc')
            ->get();

        return view('laporan.pengaduan.pengaduan', compact('laporan', 'tanggalMulai', 'tanggalSelesai'));
    }

    public function cetak(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai ?? now()->startOfMonth()->toDateString();
        $tanggalSelesai = $request->tanggal_selesai ?? now()->endOfMonth()->toDateString();

        $laporan = LaporanPengunjung::whereBetween('waktu_lapor', [$tanggalMulai . ' 00:00:00', $tanggalSelesai . ' 23:59:59'])
            ->orderBy('waktu_lapor', 'desc')
            ->get();

        $pdf = PDF::loadView('laporan.pengaduan.pengaduan_pdf', compact('laporan', 'tanggalMulai', 'tanggalSelesai'));


        return $pdf->stream('pengaduan_pdf');
    }
}
