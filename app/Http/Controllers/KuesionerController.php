<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KuesionerPertanyaan;

class KuesionerController extends Controller
{
    /**
     * NAMA METHOD: Diubah menjadi 'tampil' agar sesuai dengan template Anda.
     */
    public function tampil()
    {
        $kuesioner = KuesionerPertanyaan::orderBy('kategori')->orderBy('urutan')->get();
        return view('manajemen-kuesioner.tampil', compact('kuesioner'));
    }

    /**
     * NAMA METHOD: Diubah menjadi 'submit' dan ditambahkan try-catch.
     */
    public function submit(Request $request)
    {
        $request->validate([
            'teks_pertanyaan' => 'required|string|max:255',
            'kategori' => 'required|in:fasilitas,petugas',
            'status' => 'required|in:aktif,nonaktif',
            'urutan' => 'required|integer',
        ]);

        try {
            // PENYIMPANAN: Menggunakan new Model() dan ->save() sesuai template Anda.
            $pertanyaan = new KuesionerPertanyaan();
            $pertanyaan->teks_pertanyaan = $request->teks_pertanyaan;
            $pertanyaan->kategori = $request->kategori;
            $pertanyaan->status = $request->status;
            $pertanyaan->urutan = $request->urutan;
            $pertanyaan->save();

            // RESPONSE: Menggunakan redirect()->route() dengan pesan sukses.
            return redirect()->route('kuesioner.tampil')->with('success', 'Pertanyaan baru berhasil <strong>ditambahkan</strong>.');
        } catch (\Exception $e) {
            return redirect()->route('kuesioner.tampil')->with('error', '<strong>Gagal</strong> menambahkan pertanyaan.');
        }
    }

    /**
     * NAMA METHOD: 'update' sudah sesuai.
     */
    public function update(Request $request, $id)
    {
        // CATATAN: Validasi sangat disarankan di sini.
        try {
            $pertanyaan = KuesionerPertanyaan::findOrFail($id);

            // LOGIKA UPDATE: Menggunakan property assignment dan ->save()
            $pertanyaan->teks_pertanyaan = $request->teks_pertanyaan;
            $pertanyaan->kategori = $request->kategori;
            $pertanyaan->status = $request->status;
            $pertanyaan->urutan = $request->urutan;
            $pertanyaan->save();

            return redirect()->route('kuesioner.tampil')->with('success', 'Pertanyaan berhasil <strong>diperbarui</strong>.');
        } catch (\Exception $e) {
            return redirect()->route('kuesioner.tampil')->with('error', '<strong>Gagal</strong> memperbarui pertanyaan.');
        }
    }

    /**
     * NAMA METHOD: Diubah menjadi 'delete'.
     */
    public function delete($id)
    {
        try {
            $pertanyaan = KuesionerPertanyaan::findOrFail($id);
            $pertanyaan->delete();

            return redirect()->route('kuesioner.tampil')->with('success', 'Pertanyaan berhasil <strong>dihapus</strong>.');
        } catch (\Exception $e) {
            return redirect()->route('kuesioner.tampil')->with('error', '<strong>Gagal</strong> menghapus pertanyaan.');
        }
    }
}
