<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianJawaban extends Model
{
    protected $table = 'penilaian_jawaban';

    protected $fillable = [
        'penilaian_kepuasan_id',
        'pertanyaan_id',
        'jawaban_rating',
    ];


    public function pertanyaan()
    {
        return $this->belongsTo(KuesionerPertanyaan::class, 'pertanyaan_id');
    }


    public function penilaian()
    {
        return $this->belongsTo(PenilaianKepuasan::class, 'penilaian_kepuasan_id');
    }
}
