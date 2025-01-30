<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parkir extends Model
{
    const STATUS_TERPARKIR = 'Terparkir';
    const STATUS_KELUAR = 'Keluar';

    protected $table = 'parkir'; // Jika ingin mempertahankan nama tabel 'tarif'

    protected $fillable = [
        'plat_kendaraan',
        'status',
        'jam_keluar',
        'tarif_id',
        'tanggal',
    ];

    // Event model untuk mengisi entry_time otomatis
    protected static function booted()
    {
        static::creating(function ($record) {
            if (is_null($record->jam_masuk)) {
                $record->jam_masuk = now(); // Menggunakan timestamp sekarang
            }
        });
    }

    public function tarif()
    {
        return $this->belongsTo(Tarif::class, 'tarif_id', 'id');
    }
}
