<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jabatan')->insert([
            ['nama_jabatan' => 'Petugas Parkir'],
            ['nama_jabatan' => 'Satpam'],
            ['nama_jabatan' => 'Dokter'],
            ['nama_jabatan' => 'Perawat'],
            ['nama_jabatan' => 'Administrasi'],
        ]);
    }
}
