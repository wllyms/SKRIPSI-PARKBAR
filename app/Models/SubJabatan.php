<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubJabatan extends Model
{
    protected $table = 'sub_jabatan';

    protected $fillable = [
        'nama_sub_jabatan',
        'jabatan_id'
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    // Relasi pivot dengan nama tabel dan kolom foreign key disebutkan eksplisit
    public function pegawais()
    {
        return $this->belongsToMany(Pegawai::class, 'pegawai_sub_jabatan', 'sub_jabatan_id', 'pegawai_id')
            ->withPivot(['tanggal_mulai', 'tanggal_selesai', 'keterangan'])
            ->withTimestamps();
    }
}
