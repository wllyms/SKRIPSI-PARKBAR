<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Tarif;
use Illuminate\Http\Request;

class TarifController extends Controller
{
    public function tampil()
    {
        $tarif    = Tarif::all();
        $kategori = Kategori::all();
        return view('manajemen-tarif.tampil', compact('tarif', 'kategori'));
    }

    public function submit(Request $request)
    {
        // Tambahkan tarif baru
        $tarif               = new Tarif();
        $tarif->jenis_tarif  = $request->jenis_tarif;
        $tarif->tarif        = $request->tarif;
        $tarif->kategori_id  = $request->kategori;
        $tarif->save();

        // Set pesan sukses
        return back()->with('success', 'Tarif Berhasil Ditambahkan');
    }

    public function update(Request $request, $id)
    {
        try {
            // Cari data tarif berdasarkan ID
            $tarif = Tarif::findOrFail($id);

            // Perbarui data tarif
            $tarif->jenis_tarif     = $request->jenis_tarif;
            $tarif->tarif           = $request->tarif;
            $tarif->kategori_id     = $request->kategori;
            $tarif->save();

            // Redirect dengan pesan sukses
            return redirect()->route('manajemen-tarif.tampil')->with('success', 'User berhasil <strong>diperbarui</strong>.');
        } catch (\Exception $error) {
            // Redirect dengan pesan error jika terjadi masalah
            return redirect()->route('manajemen-tarif.tampil')->with('error', '<strong>Gagal</strong> memperbarui User.');
        }
    }

    public function delete($id)
    {
        try {
            // Cari data tarif berdasarkan ID
            $tarif = Tarif::findOrFail($id);

            // Hapus data tarif
            $tarif->delete();

            // Redirect dengan pesan sukses
            return redirect()->route('manajemen-tarif.tampil')->with('success', 'Tarif berhasil <strong>dihapus</strong>.');
        } catch (\Exception $error) {
            // Redirect dengan pesan error jika terjadi masalah
            return redirect()->route('manajemen-tarif.tampil')->with('error', '<strong>Gagal</strong> menghapus tarif.');
        }
    }
}
