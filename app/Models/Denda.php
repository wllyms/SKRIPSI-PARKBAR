<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    protected $table = 'denda'; // Jika ingin mempertahankan nama tabel 'denda'

    protected $fillable = [
        'parkir_id',
        'plat_kendaraan',
        'tanggal',
        'nominal',
        'status',
    ];

    public function parkir()
    {
        return $this->belongsTo(Parkir::class, 'parkir_id');
    }
}
