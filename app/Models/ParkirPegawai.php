<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkirPegawai extends Model
{
    const STATUS_TERPARKIR = 'Terparkir';
    const STATUS_KELUAR = 'Keluar';

    protected $table = 'parkir_pegawai';

    protected $fillable = [
        'kode_member',
        'plat_kendaraan',
        'tanggal',
        'jam_masuk',
        'pegawai_id',
        'status',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
