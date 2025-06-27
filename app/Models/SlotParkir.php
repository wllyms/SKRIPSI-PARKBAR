<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlotParkir extends Model
{
    protected $table = 'slot_parkir';

    protected $fillable = ['nama_slot', 'kapasitas'];

    public function parkir()
    {
        return $this->hasMany(Parkir::class, 'slot_parkir_id');
    }
}
