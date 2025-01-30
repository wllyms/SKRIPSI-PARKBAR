<?php

namespace App\Http\Controllers;

use App\Models\jenisPegawai;
use App\Models\JenisPegawai as ModelsJenisPegawai;
use Illuminate\Http\Request;

class JenisPegawaiController extends Controller
{
    public function tampil()
    {
        $jenis_pegawai = jenisPegawai::get(); // Ambil semua data Jenis Pegawai
        return view('manajemen-JenisPegawai.tampil', compact('jenis_pegawai'));
    }

    public function submit(Request $request)
    {
        try {
            // Tambahkan grup baru
            $jenis_pegawai                = new JenisPegawai();
            $jenis_pegawai->jenis_pegawai = $request->jenis_pegawai;
            $jenis_pegawai->save();

            // Set pesan sukses
            return redirect()->route('manajemen-JenisPegawai.tampil')->with('success', 'Jenis Pegawai berhasil <strong>ditambahkan</strong>.');
        } catch (\Exception $error) {
            // Set pesan error jika terjadi masalah
            return redirect()->route('manajemen-JenisPegawai.tampil')->with('error', '<strong>Gagal</strong> menambahkan Kategori.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Cari data Jenis Pegawai berdasarkan ID
            $jenis_pegawai                       = jenisPegawai::findOrFail($id);

            // Perbarui data Jenis Pegawai
            $jenis_pegawai->jenis_pegawai        = $request->jenis_pegawai;
            $jenis_pegawai->save();

            // Redirect dengan pesan sukses
            return redirect()->route('manajemen-JenisPegawai.tampil')->with('success', 'Jenis Pegawai berhasil <strong>diperbarui</strong>.');
        } catch (\Exception $error) {
            // Redirect dengan pesan error jika terjadi masalah
            return redirect()->route('manajemen-JenisPegawai.tampil')->with('error', '<strong>Gagal</strong> memperbarui Staff.');
        }
    }

    public function delete($id)
    {
        try {
            // Cari data Jenis Pegawai berdasarkan ID
            $jenis_pegawai = jenisPegawai::findOrFail($id);

            // Hapus data user
            $jenis_pegawai->delete();

            // Redirect dengan pesan sukses
            return redirect()->route('manajemen-JenisPegawai.tampil')->with('success', 'Jenis Pegawai berhasil <strong>dihapus</strong>.');
        } catch (\Exception $error) {
            // Redirect dengan pesan error jika terjadi masalah
            return redirect()->route('manajemen-JenisPegawai.tampil')->with('error', '<strong>Gagal</strong> menghapus User.');
        }
    }
}
