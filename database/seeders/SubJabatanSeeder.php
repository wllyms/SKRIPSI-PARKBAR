<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubJabatanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sub_jabatan')->insert([
            ['jabatan_id' => 1, 'nama_sub_jabatan' => 'Parkir Masuk'],
            ['jabatan_id' => 1, 'nama_sub_jabatan' => 'Parkir Keluar'],
            ['jabatan_id' => 2, 'nama_sub_jabatan' => 'Gerbang Utama'],
            ['jabatan_id' => 3, 'nama_sub_jabatan' => 'IGD'],
            ['jabatan_id' => 3, 'nama_sub_jabatan' => 'Poli Umum'],
            ['jabatan_id' => 4, 'nama_sub_jabatan' => 'Ruang Bersalin'],
            ['jabatan_id' => 5, 'nama_sub_jabatan' => 'Loket Pendaftaran'],
        ]);
    }
}
