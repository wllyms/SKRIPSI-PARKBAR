<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkirPegawai extends Model
{

    const STATUS_TERPARKIR = 'Terparkir';
    const STATUS_KELUAR = 'Keluar';

    protected $table = 'parkir_pegawai';


    protected $fillable = [
        'pegawai_id',
        'kode_member',
        'plat_kendaraan',
        'waktu_masuk',
        'waktu_keluar',
        'status',
    ];


    protected $casts = [
        'waktu_masuk' => 'datetime',
        'waktu_keluar' => 'datetime',
    ];


    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
