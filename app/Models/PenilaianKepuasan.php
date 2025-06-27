<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianKepuasan extends Model
{

    protected $table = 'penilaian_kepuasan';

    protected $fillable = [
        'parkir_id',
        'tuser_id',
        'komentar_fasilitas',
        'komentar_petugas',
    ];

    public function parkir()
    {
        return $this->belongsTo(Parkir::class, 'parkir_id');
    }

    public function petugas()
    {
        return $this->belongsTo(Tuser::class, 'tuser_id');
    }

    public function jawaban()
    {
        return $this->hasMany(PenilaianJawaban::class, 'penilaian_kepuasan_id');
    }

    public function jawabanFasilitas()
    {
        return $this->hasMany(PenilaianJawaban::class, 'penilaian_kepuasan_id')
            ->whereHas('pertanyaan', fn($q) => $q->where('kategori', 'fasilitas'));
    }


    public function jawabanPetugas()
    {
        return $this->hasMany(PenilaianJawaban::class, 'penilaian_kepuasan_id')
            ->whereHas('pertanyaan', fn($q) => $q->where('kategori', 'petugas'));
    }
}
