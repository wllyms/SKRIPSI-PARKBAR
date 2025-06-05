<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPengunjung extends Model
{
    protected $table = 'laporan_pengunjung';

    // Kolom yang boleh diisi secara mass-assignment
    protected $fillable = [
        'user_id',
        'nama',
        'waktu_lapor',
        'no_telp',
        'keterangan',
    ];

    // Tipe data yang harus di-cast, misal untuk kolom datetime
    protected $casts = [
        'waktu_lapor' => 'datetime',
    ];

    // Relasi: tiap laporan dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(Tuser::class);
    }
}
