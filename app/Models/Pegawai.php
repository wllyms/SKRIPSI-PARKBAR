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
        'jabatan_id'
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function subjabatan()
    {
        return $this->belongsTo(SubJabatan::class);
    }

    // Untuk riwayat mutasi (optional jika kamu pakai pivot)
    public function riwayatSubJabatans()
    {
        return $this->belongsToMany(SubJabatan::class, 'pegawai_sub_jabatan')
            ->withPivot(['tanggal_mulai', 'tanggal_selesai', 'keterangan'])
            ->withTimestamps();
    }

    public function parkirpegawai(): HasMany // One to Many relasi
    {
        return $this->hasMany(ParkirPegawai::class, 'pegawai_id', 'id');;
    }
}
