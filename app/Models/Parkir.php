<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parkir extends Model
{
    const STATUS_TERPARKIR = 'Terparkir';
    const STATUS_KELUAR = 'Keluar';

    protected $table = 'parkir';

    protected $fillable = [
        'plat_kendaraan',
        'tarif_id',
        'user_id',
        'waktu_masuk',
        'waktu_keluar',
        'status',
    ];

    // **Tambahkan casting di sini:**
    protected $casts = [
        'waktu_masuk' => 'datetime',
        'waktu_keluar' => 'datetime',
    ];

    // Event model untuk mengisi waktu_masuk otomatis saat create
    protected static function booted()
    {
        static::creating(function ($record) {
            if (is_null($record->waktu_masuk)) {
                $record->waktu_masuk = now();
            }
        });
    }

    // Relasi ke tarif
    public function tarif()
    {
        return $this->belongsTo(Tarif::class, 'tarif_id', 'id');
    }

    // Relasi ke denda (jika ada tabel denda)
    public function denda()
    {
        return $this->hasOne(Denda::class, 'parkir_id');
    }

    public function user()
    {
        return $this->belongsTo(Tuser::class, 'user_id');
    }
}
