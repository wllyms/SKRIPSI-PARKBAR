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
        'jabatan_id',
        'sub_jabatan_id'
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function subjabatan()
    {
        return $this->belongsTo(SubJabatan::class, 'sub_jabatan_id');
    }

    // Relasi pivot dengan nama tabel dan kolom foreign key disebutkan eksplisit
    public function riwayatSubJabatans()
    {
        return $this->belongsToMany(SubJabatan::class, 'pegawai_sub_jabatan', 'pegawai_id', 'sub_jabatan_id')
            ->withPivot(['tanggal_mulai', 'tanggal_selesai', 'keterangan'])
            ->withTimestamps();
    }

    public function parkirpegawai(): HasMany
    {
        return $this->hasMany(ParkirPegawai::class, 'pegawai_id', 'id');
    }
}
