<?php

namespace App\Http\Controllers;

use App\Models\SubJabatan;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class SubJabatanController extends Controller
{
    public function tampil()
    {
        $subjabatan = SubJabatan::with('jabatan')->get();
        $jabatans = Jabatan::all();

        return view('manajemen-subjabatan.tampil', compact('subjabatan', 'jabatans'));
    }

    public function submit(Request $request)
    {
        try {
            $sub = new SubJabatan();
            $sub->jabatan_id = $request->jabatan_id;
            $sub->nama_sub_jabatan = $request->nama_sub_jabatan;
            $sub->save();

            return redirect()->route('manajemen-subjabatan.tampil')->with('success', 'Sub Jabatan berhasil <strong>ditambahkan</strong>.');
        } catch (\Exception $error) {
            return redirect()->route('manajemen-subjabatan.tampil')->with('error', '<strong>Gagal</strong> menambahkan Sub Jabatan.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $sub = SubJabatan::findOrFail($id);
            $sub->jabatan_id = $request->jabatan_id;
            $sub->nama_sub_jabatan = $request->nama_sub_jabatan;
            $sub->save();

            return redirect()->route('manajemen-subjabatan.tampil')->with('success', 'Sub Jabatan berhasil <strong>diperbarui</strong>.');
        } catch (\Exception $error) {
            return redirect()->route('manajemen-subjabatan.tampil')->with('error', '<strong>Gagal</strong> memperbarui Sub Jabatan.');
        }
    }

    public function delete($id)
    {
        try {
            $sub = SubJabatan::findOrFail($id);
            $sub->delete();

            return redirect()->route('manajemen-subjabatan.tampil')->with('success', 'Sub Jabatan berhasil <strong>dihapus</strong>.');
        } catch (\Exception $error) {
            return redirect()->route('manajemen-subjabatan.tampil')->with('error', '<strong>Gagal</strong> menghapus Sub Jabatan.');
        }
    }
}
