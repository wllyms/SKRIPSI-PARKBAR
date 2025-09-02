<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SlotParkir extends Model
{
    protected $table = 'slot_parkir';

    protected $fillable = [
        'nama_slot',
        'kapasitas',
        'kategori_id' // Tambahkan ini
    ];

    /**
     * Relasi ke model Kategori (one to one).
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function parkir(): HasMany
    {
        return $this->hasMany(Parkir::class, 'slot_parkir_id', 'id');
    }
}
