<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    protected $table = 'staff';

    protected $fillable = [
        'nama',
        'no_telp',
        'alamat',

    ];

    public function users(): HasMany // One to Many relasi
    {
        return $this->hasMany(Userr::class);
    }
}
