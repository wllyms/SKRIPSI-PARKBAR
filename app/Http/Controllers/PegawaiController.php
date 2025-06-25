<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\JenisPegawai;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;


class PegawaiController extends Controller
{
    public function tampil()
    {
        $pegawai = Pegawai::all();
        $jenis_pegawai = JenisPegawai::all();
        return view('manajemen-pegawai.tampil', compact('pegawai', 'jenis_pegawai'));
    }

    public function submit(Request $request)
    {
        // Validasi input (opsional, tambahkan sesuai kebutuhan)
        // $request->validate([...]);

        $pegawai = new Pegawai();
        $pegawai->plat_kendaraan    = $request->plat_kendaraan;
        $pegawai->nama              = $request->nama;
        $pegawai->no_telp           = $request->no_telp;
        $pegawai->email             = $request->email;
        $pegawai->alamat            = $request->alamat;
        $pegawai->merk_kendaraan    = $request->merk_kendaraan;
        $pegawai->jenis_pegawai_id  = $request->jenis_pegawai;


        $latestId = Pegawai::max('id') ?? 0;
        $nextId = $latestId + 1;
        $kodeMember = 'MBR-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
        $pegawai->kode_member = $kodeMember;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('pegawai_images', 'public');
            $pegawai->image = $path;
        }

        $pegawai->save();

        return back()->with('success', 'Pegawai berhasil ditambahkan dengan Kode Member: ' . $kodeMember);
    }


    public function cetakPegawai($id)
    {
        // Ambil data pegawai berdasarkan ID dengan relasi jenisPegawai
        $pegawai = Pegawai::with('jenisPegawai')->findOrFail($id);

        return view('manajemen-pegawai.detailpegawai', compact('pegawai'));
    }


    public function update(Request $request, $id)
    {
        try {
            // Cari pegawai berdasarkan ID
            $pegawai = Pegawai::findOrFail($id);

            // Update data pegawai
            $pegawai->plat_kendaraan    = $request->plat_kendaraan;
            $pegawai->nama              = $request->nama;
            $pegawai->no_telp           = $request->no_telp;
            $pegawai->email             = $request->email;
            $pegawai->alamat            = $request->alamat;
            $pegawai->merk_kendaraan    = $request->merk_kendaraan;
            $pegawai->jenis_pegawai_id = $request->jenis_pegawai_id;

            // Jika ada file gambar baru yang diunggah
            if ($request->hasFile('image')) {
                // Hapus file lama jika ada dan ada file baru yang diupload
                if ($pegawai->image && Storage::exists('public/' . $pegawai->image)) {
                    Storage::delete('public/' . $pegawai->image);
                }

                // Simpan file baru
                $file = $request->file('image');
                $path = $file->store('pegawai_images', 'public'); // Simpan ke folder "pegawai_images" di disk "public"
                $pegawai->image = $path; // Simpan path ke database
            }

            // Simpan perubahan ke database
            $pegawai->save();

            // Redirect dengan pesan sukses
            return back()->with('success', 'Pegawai berhasil diperbarui.');
        } catch (\Exception $e) {
            // Redirect dengan pesan error tanpa mencatat log
            return back()->with('error', 'Gagal memperbarui pegawai: ' . $e->getMessage());
        }
    }

    public function laporan(Request $request)
    {
        $jenisPegawaiFilter = $request->input('jenis_pegawai');
        $pegawai = $jenisPegawaiFilter
            ? Pegawai::where('jenis_pegawai_id', $jenisPegawaiFilter)->get()
            : Pegawai::all();

        $jenis_pegawai = JenisPegawai::all();

        return view('laporan.pegawai.pegawai', compact('pegawai', 'jenis_pegawai'));
    }

    public function cetakLaporan(Request $request)
    {
        $jenisPegawaiFilter = $request->input('jenis_pegawai');
        $pegawai = $jenisPegawaiFilter
            ? Pegawai::where('jenis_pegawai_id', $jenisPegawaiFilter)->get()
            : Pegawai::all();

        // Menambahkan data jenis_pegawai jika perlu di PDF
        $jenis_pegawai = JenisPegawai::all();

        $pdf = Pdf::loadView('laporan.pegawai.pegawai_pdf', compact('pegawai', 'jenis_pegawai'));
        return $pdf->stream('laporan-pegawai.pdf');
    }


    public function delete($id)
    {
        try {
            $pegawai = Pegawai::findOrFail($id);
            $pegawai->delete();

            return redirect()->route('manajemen-pegawai.tampil')->with('success', 'Pegawai berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('manajemen-pegawai.tampil')->with('error', 'Gagal menghapus pegawai: ' . $e->getMessage());
        }
    }

    public function cetakDetailPegawai($id)
    {
        // Cari data pegawai berdasarkan ID
        $data = Pegawai::findOrFail($id);

        // Periksa apakah pegawai memiliki foto
        if (!empty($data->image)) {
            $imagePath = public_path('storage/' . $data->image);

            // Periksa apakah file gambar tersedia
            if (!file_exists($imagePath)) {
                $data->image = null; // Jika file tidak ditemukan, set gambar ke null
            }
        } else {
            $data->image = null; // Jika gambar tidak ada dalam database, set ke null
        }

        // Generate PDF menggunakan view yang telah disesuaikan
        $pdf = PDF::loadView('laporan.pegawai.detail_pegawaipdf', compact('data'))
            ->setPaper('a4', 'landscape');

        // Return file PDF sebagai stream ke browser
        return $pdf->stream('detail_pegawai_' . $data->nama . '.pdf');
    }
}
