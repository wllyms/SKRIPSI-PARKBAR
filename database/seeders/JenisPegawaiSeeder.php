<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JenisPegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis_pegawai')->insert([
            'jenis_pegawai'    => 'IT',
        ]);

        DB::table('jenis_pegawai')->insert([
            'jenis_pegawai'    => 'RM',
        ]);
    }
}
