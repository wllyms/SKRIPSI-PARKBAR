<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KuesionerPertanyaan extends Model
{
    protected $table = 'kuesioner_pertanyaan';

    protected $fillable = [
        'teks_pertanyaan',
        'kategori',
        'tipe_jawaban',
        'status',
        'urutan',
    ];

    public function jawaban()
    {
        return $this->hasMany(PenilaianJawaban::class, 'pertanyaan_id');
    }
}
