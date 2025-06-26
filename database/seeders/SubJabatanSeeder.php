<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubJabatanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sub_jabatan')->insert([
            ['nama_sub_jabatan' => 'Dokter Umum', 'jabatan_id' => 1],
            ['nama_sub_jabatan' => 'Dokter Spesialis', 'jabatan_id' => 1],
            ['nama_sub_jabatan' => 'Perawat IGD', 'jabatan_id' => 2],
            ['nama_sub_jabatan' => 'Perawat Rawat Inap', 'jabatan_id' => 2],
            ['nama_sub_jabatan' => 'Satpam Pintu Utama', 'jabatan_id' => 3],
            ['nama_sub_jabatan' => 'Satpam Parkiran', 'jabatan_id' => 3],
            ['nama_sub_jabatan' => 'Admin Pendaftaran', 'jabatan_id' => 4],
            ['nama_sub_jabatan' => 'Admin Rekam Medis', 'jabatan_id' => 4],
            ['nama_sub_jabatan' => 'Teknisi Listrik', 'jabatan_id' => 5],
            ['nama_sub_jabatan' => 'Teknisi Mesin', 'jabatan_id' => 5],
            ['nama_sub_jabatan' => 'Petugas Kebersihan Gedung', 'jabatan_id' => 6],
            ['nama_sub_jabatan' => 'Petugas Kebersihan Taman', 'jabatan_id' => 6],
        ]);
    }
}
