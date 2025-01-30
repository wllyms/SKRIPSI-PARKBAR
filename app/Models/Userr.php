<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Userr extends Model
{
    protected $table = 'userr';

    protected $fillable = [
        'username',
        'password',
        'role',
        'staff_id'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class); // nama tabel, nama kolom di tabel ini, nama kolom di tabel lain
    }
}
