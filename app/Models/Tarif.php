<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tarif extends Model
{
    protected $table = 'tarif'; // Jika ingin mempertahankan nama tabel 'tarif'

    protected $fillable = [
        'jenis_tarif',
        'tarif',
        'kategori_id'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function parkir(): HasMany // One to Many relasi
    {
        return $this->hasMany(Parkir::class, 'tarif_id', 'id');;
    }
}
