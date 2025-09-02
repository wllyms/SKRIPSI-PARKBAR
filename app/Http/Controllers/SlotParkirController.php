<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Parkir;
use App\Models\Kategori;
use App\Models\SlotParkir;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SlotParkirController extends Controller
{
    public function tampil()
    {
        $slot = SlotParkir::all();
        $kategori = Kategori::all(); // Tambahkan baris ini
        return view('manajemen-slot.tampil', compact('slot', 'kategori')); // Tambahkan 'kategori' di sini
    }

    public function submit(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_slot'   => 'required|unique:slot_parkir,nama_slot',
            'kapasitas'   => 'required|integer|min:1',
            'kategori_id' => 'required|exists:kategori,id',
        ], [
            'nama_slot.required'   => 'Nama slot wajib diisi.',
            'nama_slot.unique'     => 'Nama slot sudah digunakan.',
            'kapasitas.required'   => 'Kapasitas wajib diisi.',
            'kapasitas.integer'    => 'Kapasitas harus berupa angka.',
            'kapasitas.min'        => 'Kapasitas minimal 1.',
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'kategori_id.exists'   => 'Kategori tidak valid.',
        ]);

        try {
            // Simpan data slot parkir
            SlotParkir::create([
                'nama_slot'   => $request->nama_slot,
                'kapasitas'   => $request->kapasitas,
                'kategori_id' => $request->kategori_id,
            ]);

            return redirect()
                ->route('manajemen-slot.tampil')
                ->with('success', 'Slot parkir berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan slot: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_slot' => 'required|unique:slot_parkir,nama_slot,' . $id,
            'kapasitas' => 'required|integer|min:1',
        ]);

        try {
            $slot = SlotParkir::findOrFail($id);
            $slot->update([
                'nama_slot' => $request->nama_slot,
                'kapasitas' => $request->kapasitas,
            ]);
            return redirect()->route('manajemen-slot.tampil')->with('success', 'Slot parkir berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui slot: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $slot = SlotParkir::findOrFail($id);
            $slot->delete();
            return redirect()->route('manajemen-slot.tampil')->with('success', 'Slot parkir berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus slot: ' . $e->getMessage());
        }
    }

    public function laporanSlot(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai') ?? now()->startOfMonth()->format('Y-m-d');
        $tanggalSelesai = $request->input('tanggal_selesai') ?? now()->endOfMonth()->format('Y-m-d');
        $slotId = $request->input('slot_id');

        $query = SlotParkir::query();

        if ($slotId) {
            $query->where('id', $slotId);
        }

        $dataSlot = $query->withCount([
            'parkir as terpakai_sekarang' => fn($q) =>
            $q->where('status', 'Terparkir'),

            'parkir as riwayat_terisi' => fn($q) =>
            $q->whereBetween('waktu_masuk', [
                Carbon::parse($tanggalMulai)->startOfDay(),
                Carbon::parse($tanggalSelesai)->endOfDay()
            ]),

            'parkir as total_keluar' => fn($q) =>
            $q->whereBetween('waktu_keluar', [
                Carbon::parse($tanggalMulai)->startOfDay(),
                Carbon::parse($tanggalSelesai)->endOfDay()
            ])->whereNotNull('waktu_keluar'),
        ])->get();

        // Untuk dropdown select
        $semuaSlot = SlotParkir::select('id', 'nama_slot')->get();

        return view('laporan.slotparkir.slotparkir', compact(
            'dataSlot',
            'tanggalMulai',
            'tanggalSelesai',
            'slotId',
            'semuaSlot'
        ));
    }

    public function cetakPDF(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');
        $slotId = $request->input('slot_id');

        $query = SlotParkir::query();

        if ($slotId) {
            $query->where('id', $slotId);
        }

        $dataSlot = $query->withCount([
            'parkir as terpakai_sekarang' => fn($q) =>
            $q->where('status', 'Terparkir'),

            'parkir as riwayat_terisi' => fn($q) =>
            $q->whereBetween('waktu_masuk', [
                Carbon::parse($tanggalMulai)->startOfDay(),
                Carbon::parse($tanggalSelesai)->endOfDay()
            ]),

            'parkir as total_keluar' => fn($q) =>
            $q->whereBetween('waktu_keluar', [
                Carbon::parse($tanggalMulai)->startOfDay(),
                Carbon::parse($tanggalSelesai)->endOfDay()
            ])->whereNotNull('waktu_keluar'),
        ])->get();

        $namaSlot = $slotId ? SlotParkir::find($slotId)?->nama_slot : 'Semua Slot';

        $pdf = Pdf::loadView('laporan.slotparkir.slot_pdf', compact(
            'dataSlot',
            'tanggalMulai',
            'tanggalSelesai',
            'slotId',
            'namaSlot'
        ))->setPaper('A4', 'landscape');

        return $pdf->stream('laporan_slot_parkir.pdf');
    }
}
