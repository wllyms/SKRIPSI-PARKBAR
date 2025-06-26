<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function tampil()
    {
        $jabatan = Jabatan::all();
        return view('manajemen-jabatan.tampil', compact('jabatan'));
    }

    public function submit(Request $request)
    {
        try {
            $jabatan = new Jabatan();
            $jabatan->nama_jabatan = $request->nama_jabatan;
            $jabatan->save();

            return redirect()->route('manajemen-jabatan.tampil')->with('success', 'Jabatan berhasil <strong>ditambahkan</strong>.');
        } catch (\Exception $error) {
            return redirect()->route('manajemen-jabatan.tampil')->with('error', '<strong>Gagal</strong> menambahkan Jabatan.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $jabatan = Jabatan::findOrFail($id);
            $jabatan->nama_jabatan = $request->nama_jabatan;
            $jabatan->save();

            return redirect()->route('manajemen-jabatan.tampil')->with('success', 'Jabatan berhasil <strong>diperbarui</strong>.');
        } catch (\Exception $error) {
            return redirect()->route('manajemen-jabatan.tampil')->with('error', '<strong>Gagal</strong> memperbarui Jabatan.');
        }
    }

    public function delete($id)
    {
        try {
            $jabatan = Jabatan::findOrFail($id);
            $jabatan->delete();

            return redirect()->route('manajemen-jabatan.tampil')->with('success', 'Jabatan berhasil <strong>dihapus</strong>.');
        } catch (\Exception $error) {
            return redirect()->route('manajemen-jabatan.tampil')->with('error', '<strong>Gagal</strong> menghapus Jabatan.');
        }
    }
}
