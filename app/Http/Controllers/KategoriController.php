<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\New_;

class KategoriController extends Controller
{
    public function tampil()
    {
        $kategori = Kategori::get();
        return view('manajemen-kategori.tampil', compact('kategori'));
    }

    public function submit(Request $request)
    {
        try {
            // Tambahkan grup baru
            $kategori = new Kategori();
            $kategori->nama_kategori = $request->nama_kategori;
            $kategori->save();

            // Set pesan sukses
            return redirect()->route('manajemen-kategori.tampil')->with('success', 'Kategori berhasil <strong>ditambahkan</strong>.');
        } catch (\Exception $error) {
            // Set pesan error jika terjadi masalah
            return redirect()->route('manajemen-kategori.tampil')->with('error', '<strong>Gagal</strong> menambahkan Kategori.');
        }
    }

    public function update(Request $request, $id)
    {
        $kategori            = Kategori::find($id);
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->update();

        return redirect()->route('manajemen-kategori.tampil')->with('success', 'Kategori berhasil <strong>diedit</strong>.');
    }


    public function delete($id)
    {
        // Cari kategori berdasarkan ID
        $kategori = Kategori::findOrFail($id);

        // Hapus kategori
        $kategori->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('manajemen-kategori.tampil')->with('success', 'Kategori berhasil <strong>dihapus</strong>.');
    }
}
