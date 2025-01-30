<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisPegawai extends Model
{
    protected $table = 'jenis_pegawai';

    protected $fillable = [
        'jenis_pegawai'

    ];

    public function pegawai(): HasMany // One to Many relasi
    {
        return $this->hasMany(Pegawai::class, 'jenis_pegawai_id', 'id');
    }
}
