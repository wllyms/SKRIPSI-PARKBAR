<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Kategori extends Model
{
    protected $table = 'kategori'; // Jika ingin mempertahankan nama tabel 'kategori'
    protected $fillable = ['nama_kategori'];

    public function tarifs(): HasMany // One to Many relasi
    {
        return $this->hasMany(Tarif::class, 'kategori_id', 'id');
    }

    // public function parkirs(): HasManyThrough
    // {
    //     return $this->hasManyThrough(
    //         Parkir::class,    // Model tujuan
    //         Tarif::class,     // Model perantara
    //         'kategori_id',    // Foreign key di tarif
    //         'tarif_id',       // Foreign key di parkir
    //         'id',             // Local key di kategori
    //         'id'              // Local key di tarif
    //     );
    // }
}
