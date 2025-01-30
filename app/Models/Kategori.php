<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    protected $table = 'kategori'; // Jika ingin mempertahankan nama tabel 'kategori'
    protected $fillable = ['nama_kategori'];

    public function tarifs(): HasMany // One to Many relasi
    {
        return $this->hasMany(Tarif::class, 'kategori_id', 'id');
    }

    public function parkirs(): HasMany // One to Many relasi
    {
        return $this->hasMany(Parkir::class, 'kategori_id', 'id');
    }
}
