<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PegawaiSubJabatanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pegawai_sub_jabatan')->insert([
            [
                'pegawai_id'       => 1, // asumsi pegawai dengan ID 1 adalah "Rudi"
                'sub_jabatan_id'   => 1, // Parkir Masuk
                'tanggal_mulai'    => '2025-01-01',
                'tanggal_selesai'  => '2025-03-01',
                'keterangan'       => 'Shift Pagi'
            ],
            [
                'pegawai_id'       => 1,
                'sub_jabatan_id'   => 2, // Parkir Keluar
                'tanggal_mulai'    => '2025-03-02',
                'tanggal_selesai'  => null,
                'keterangan'       => 'Masih aktif'
            ],
            [
                'pegawai_id'       => 2, // pegawai lain
                'sub_jabatan_id'   => 4, // IGD
                'tanggal_mulai'    => '2025-01-10',
                'tanggal_selesai'  => null,
                'keterangan'       => 'Standby IGD'
            ],
        ]);
    }
}
