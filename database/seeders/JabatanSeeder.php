<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jabatan')->insert([
            ['nama_jabatan' => 'Dokter'],
            ['nama_jabatan' => 'Perawat'],
            ['nama_jabatan' => 'Petugas Keamanan'],
            ['nama_jabatan' => 'Administrasi'],
            ['nama_jabatan' => 'Teknisi'],
            ['nama_jabatan' => 'Cleaning Service'],
        ]);
    }
}
