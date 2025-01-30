<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grup extends Model
{
    protected $table = 'grupp'; // Jika ingin mempertahankan nama tabel 'grupp'
    protected $fillable = ['nama_grup'];

    public function users(): HasMany // One to Many relasi
    {
        return $this->hasMany(Userr::class, 'grup_id', 'id');;
    }
}
