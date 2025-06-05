<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\Parkir;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    public function tampil()
    {
        $denda = Denda::with(['parkir.tarif.kategori'])
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('manajemen-denda.tampil', compact('denda'));
    }

    public function bayar($id)
    {
        $denda = Denda::findOrFail($id);

        if ($denda->status == 'Sudah Dibayar') {
            return redirect()->route('manajemen-denda.tampil')
                ->with('warning', 'Denda ini sudah dibayar.');
        }

        $denda->update([
            'status' => 'Sudah Dibayar',
        ]);

        return redirect()->route('manajemen-denda.tampil')
            ->with('success', 'Denda berhasil dibayar.');
    }
}
