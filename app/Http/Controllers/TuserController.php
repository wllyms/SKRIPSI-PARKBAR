<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Tuser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TuserController extends Controller
{
    public function tampil()
    {
        $user = Tuser::get(); // Ambil semua data user
        $staff = Staff::get(); // Ambil semua data grup
        return view('manajemen-user.tampil', compact('user', 'staff'));
    }

    public function submit(Request $request)
    {
        // Tambahkan user baru
        $user            = new Tuser();
        $user->username  = $request->username;
        $user->password  = Hash::make($request->password); // Hash password
        $user->role      = $request->role;
        $user->staff_id  = $request->staff_id;
        $user->save();

        // Set pesan sukses
        return back()->with('success', 'User Berhasil Ditambahkan');
    }


    public function update(Request $request, $id)
    {
        try {

            // Cari data user berdasarkan ID
            $user = Tuser::findOrFail($id);

            // Perbarui data user
            $user->username = $request->username;
            if ($request->password) { // Hanya hash dan simpan password jika field password diisi
                $user->password = Hash::make($request->password);
            }
            $user->role      = $request->role;
            $user->staff_id  = $request->staff;
            $user->save();

            // Redirect dengan pesan sukses
            return redirect()->route('manajemen-user.tampil')->with('success', 'User berhasil <strong>diperbarui</strong>.');
        } catch (\Exception $error) {
            // Redirect dengan pesan error jika terjadi masalah
            return redirect()->route('manajemen-user.tampil')->with('error', '<strong>Gagal</strong> memperbarui User.');
        }
    }


    public function delete($id)
    {
        try {
            // Cari data user berdasarkan ID
            $user = Tuser::findOrFail($id);

            // Hapus data user
            $user->delete();

            // Redirect dengan pesan sukses
            return redirect()->route('manajemen-user.tampil')->with('success', 'User berhasil <strong>dihapus</strong>.');
        } catch (\Exception $error) {
            // Redirect dengan pesan error jika terjadi masalah
            return redirect()->route('manajemen-user.tampil')->with('error', '<strong>Gagal</strong> menghapus User.');
        }
    }
}
