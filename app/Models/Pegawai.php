<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pegawai extends Model
{
    protected $table = 'pegawai';

    protected $fillable = [
        'kode_member',
        'plat_kendaraan',
        'nama',
        'no_telp',
        'email',
        'alamat',
        'merk_kendaraan',
        'image',
        'jenis_pegawai_id'
    ];

    public function jenispegawai()
    {
        return $this->belongsTo(JenisPegawai::class, 'jenis_pegawai_id', 'id');
    }

    public function parkirpegawai(): HasMany // One to Many relasi
    {
        return $this->hasMany(ParkirPegawai::class, 'pegawai_id', 'id');;
    }
}
