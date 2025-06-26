<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\SubJabatan;
use App\Models\JenisPegawai;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;


class PegawaiController extends Controller
{
    public function tampil()
    {
        $pegawai     = Pegawai::with(['jabatan', 'subjabatan'])->get();
        $jabatan     = Jabatan::all();
        $subjabatan  = SubJabatan::all();

        return view('manajemen-pegawai.tampil', compact('pegawai', 'jabatan', 'subjabatan'));
    }

    public function submit(Request $request)
    {
        $pegawai = new Pegawai();
        $pegawai->plat_kendaraan    = $request->plat_kendaraan;
        $pegawai->nama              = $request->nama;
        $pegawai->no_telp           = $request->no_telp;
        $pegawai->email             = $request->email;
        $pegawai->alamat            = $request->alamat;
        $pegawai->merk_kendaraan    = $request->merk_kendaraan;
        $pegawai->jabatan_id        = $request->jabatan_id;
        $pegawai->sub_jabatan_id    = $request->sub_jabatan_id;

        // Generate kode member otomatis
        $latestId    = Pegawai::max('id') ?? 0;
        $nextId      = $latestId + 1;
        $kodeMember  = 'MBR-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
        $pegawai->kode_member = $kodeMember;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('pegawai_images', 'public');
            $pegawai->image = $path;
        }

        $pegawai->save();

        return back()->with('success', 'Pegawai berhasil ditambahkan dengan Kode Member: ' . $kodeMember);
    }

    public function update(Request $request, $id)
    {
        try {
            $pegawai = Pegawai::findOrFail($id);

            $pegawai->plat_kendaraan    = $request->plat_kendaraan;
            $pegawai->nama              = $request->nama;
            $pegawai->no_telp           = $request->no_telp;
            $pegawai->email             = $request->email;
            $pegawai->alamat            = $request->alamat;
            $pegawai->merk_kendaraan    = $request->merk_kendaraan;
            $pegawai->jabatan_id        = $request->jabatan_id;
            $pegawai->sub_jabatan_id    = $request->sub_jabatan_id;

            if ($request->hasFile('image')) {
                if ($pegawai->image && Storage::exists('public/' . $pegawai->image)) {
                    Storage::delete('public/' . $pegawai->image);
                }

                $file = $request->file('image');
                $path = $file->store('pegawai_images', 'public');
                $pegawai->image = $path;
            }

            $pegawai->save();

            return back()->with('success', 'Pegawai berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui pegawai: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $pegawai = Pegawai::findOrFail($id);

            if ($pegawai->image && Storage::exists('public/' . $pegawai->image)) {
                Storage::delete('public/' . $pegawai->image);
            }

            $pegawai->delete();

            return redirect()->route('manajemen-pegawai.tampil')->with('success', 'Pegawai berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('manajemen-pegawai.tampil')->with('error', 'Gagal menghapus pegawai: ' . $e->getMessage());
        }
    }

    public function cetakPegawai($id)
    {
        $pegawai = Pegawai::with(['jabatan', 'subjabatan'])->findOrFail($id);
        return view('manajemen-pegawai.detailpegawai', compact('pegawai'));
    }

    public function laporan(Request $request)
    {
        $jabatan_id = $request->input('jabatan_id');
        $sub_jabatan_id = $request->input('sub_jabatan_id');

        $pegawai = Pegawai::with(['jabatan', 'subjabatan', 'riwayatSubJabatans'])
            ->when($jabatan_id, fn($query) => $query->where('jabatan_id', $jabatan_id))
            ->when($sub_jabatan_id, fn($query) => $query->where('sub_jabatan_id', $sub_jabatan_id))
            ->get();

        $jabatan = Jabatan::all();
        $subjabatan = SubJabatan::all();

        return view('laporan.pegawai.pegawai', compact('pegawai', 'jabatan', 'subjabatan'));
    }


    public function cetakLaporan(Request $request)
    {
        $jabatanFilter = $request->input('jabatan_id');
        $pegawai = $jabatanFilter
            ? Pegawai::where('jabatan_id', $jabatanFilter)->get()
            : Pegawai::all();

        $jabatan = Jabatan::all();

        $pdf = Pdf::loadView('laporan.pegawai.pegawai_pdf', compact('pegawai', 'jabatan'));
        return $pdf->stream('laporan-pegawai.pdf');
    }

    public function showDetail($id)
    {
        $data = Pegawai::with('riwayatSubJabatans')->findOrFail($id);
        $subjabatans = SubJabatan::all(); // <-- ini penting

        return view('laporan.pegawai.detailpegawai', compact('data', 'subjabatans'));
    }


    public function formRiwayat($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $subjabatans = SubJabatan::all();

        return view('pegawai.form_riwayat', compact('pegawai', 'subjabatans'));
    }

    public function TambahRiwayat(Request $request, $id)
    {
        $request->validate([
            'sub_jabatan_id' => 'required|exists:sub_jabatan,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $pegawai = Pegawai::findOrFail($id);

        // Simpan ke pivot (riwayat)
        $pegawai->riwayatSubJabatans()->attach($request->sub_jabatan_id, [
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keterangan' => $request->keterangan,
        ]);


        $pegawai->sub_jabatan_id = $request->sub_jabatan_id;
        $pegawai->save();

        return redirect()->route('laporan.detailpegawai.show', $pegawai->id)
            ->with('success', 'Riwayat berhasil ditambahkan & data utama diperbarui.');
    }



    public function cetakDetailPegawai($id)
    {
        $data = Pegawai::with(['jabatan', 'subjabatan', 'riwayatSubJabatans'])->findOrFail($id);

        if (!empty($data->image)) {
            $imagePath = public_path('storage/' . $data->image);
            if (!file_exists($imagePath)) {
                $data->image = null;
            }
        } else {
            $data->image = null;
        }

        $pdf = PDF::loadView('laporan.pegawai.detail_pegawaipdf', compact('data'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('detail_pegawai_' . $data->nama . '.pdf');
    }
}
