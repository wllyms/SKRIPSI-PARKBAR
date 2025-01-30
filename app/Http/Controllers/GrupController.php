<?php

namespace App\Http\Controllers;

use App\Models\Grup;
use Illuminate\Http\Request;

class GrupController extends Controller
{
    public function tampil()
    {
        $grup = Grup::all(); // Ambil semua data grup
        return view('manajemen-grup.tampil', compact('grup'));
    }

    public function submit(Request $request)
    {
        try {
            // Validasi data
            $request->validate([ 
                'nama_grup' => 'required|string|max:255',
            ]);

            // Tambahkan grup baru
            $grup = new Grup();
            $grup->nama_grup = $request->nama_grup;
            $grup->save();

            // Set pesan sukses
            return redirect()->route('manajemen-grup.tampil')->with('success', 'Grup berhasil <strong>ditambahkan</strong>.');
        } catch (\Exception $error) {
            // Set pesan error jika terjadi masalah
            return redirect()->route('manajemen-grup.tampil')->with('error', '<strong>Gagal</strong> menambahkan grup.');
        }
    }


    public function update(Request $request, $id)
    {
        $grup            = Grup::find($id);
        $grup->nama_grup = $request->nama_grup;
        $grup->update();

        return redirect()->route('manajemen-grup.tampil')->with('success', 'Grup berhasil <strong>diedit</strong>.');
    }


    public function delete($id)
    {
        // Cari grup berdasarkan ID
        $grup = Grup::findOrFail($id);

        // Hapus grup
        $grup->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('manajemen-grup.tampil')->with('success', 'Grup berhasil <strong>dihapus</strong>.');
    }
}
