<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Tuser extends Authenticatable
{
    use Notifiable;

    protected $table = 'tuser'; // Sesuaikan dengan nama tabel di database

    protected $primaryKey = 'id'; // Sesuaikan dengan primary key tabel kamu

    public $timestamps = false; // Nonaktifkan timestamps jika tabel tidak punya created_at & updated_at

    protected $fillable = [
        'username',
        'password',
        'role',
        'staff_id'
    ];

    protected $hidden = [
        'password',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
