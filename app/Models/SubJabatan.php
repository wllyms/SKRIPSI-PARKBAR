<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function pegawais()
    {
        return $this->belongsToMany(Pegawai::class, 'pegawai_sub_jabatan')
            ->withPivot(['tanggal_mulai', 'tanggal_selesai', 'keterangan'])
            ->withTimestamps();
    }
}
