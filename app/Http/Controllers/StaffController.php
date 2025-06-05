<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function tampil()
    {
        $staff = Staff::get(); // Ambil semua data staff
        // $grup = Grup::get(); // Ambil semua data grup
        return view('manajemen-staff.tampil', compact('staff'));
    }

    public function submit(Request $request)
    {
        $staff = new Staff();
        $staff->nama = $request->nama;
        $staff->no_telp = $request->no_telp; 
        $staff->alamat = $request->alamat;
        $staff->save();

        // Set pesan sukses
        return back()->with('success', 'Staff Berhasil Ditambahkan');
    }

    public function update(Request $request, $id)
    {
        try {
            // Cari data tarif berdasarkan ID
            $staff = Staff::findOrFail($id);

            // Perbarui data tarif
            $staff->nama        = $request->nama;
            $staff->no_telp     = $request->no_telp;
            $staff->alamat      = $request->alamat;
            $staff->save();

            // Redirect dengan pesan sukses
            return redirect()->route('manajemen-staff.tampil')->with('success', 'Staff berhasil <strong>diperbarui</strong>.');
        } catch (\Exception $error) {
            // Redirect dengan pesan error jika terjadi masalah
            return redirect()->route('manajemen-staff.tampil')->with('error', '<strong>Gagal</strong> memperbarui Staff.');
        }
    }

    public function delete($id)
    {
        try {
            // Cari data Staff berdasarkan ID
            $staff = Staff::findOrFail($id);

            // Hapus data Staff
            $staff->delete();

            // Redirect dengan pesan sukses
            return redirect()->route('manajemen-staff.tampil')->with('success', 'Staff berhasil <strong>dihapus</strong>.');
        } catch (\Exception $error) {
            // Redirect dengan pesan error jika terjadi masalah
            return redirect()->route('manajemen-staff.tampil')->with('error', '<strong>Gagal</strong> menghapus User.');
        }
    }
}
