<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RiwayatSubJabatanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pegawai_sub_jabatan')->insert([
            [
                'pegawai_id'      => 1, // Dr. Andi Pratama
                'sub_jabatan_id'  => 1, // Dokter Umum
                'tanggal_mulai'   => Carbon::now()->subYears(2)->format('Y-m-d'),
                'tanggal_selesai' => Carbon::now()->subYear()->format('Y-m-d'),
                'keterangan'      => 'Penugasan awal sebagai dokter umum',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'pegawai_id'      => 1,
                'sub_jabatan_id'  => 2, // Dokter Spesialis (misal)
                'tanggal_mulai'   => Carbon::now()->subYear()->format('Y-m-d'),
                'tanggal_selesai' => null,
                'keterangan'      => 'Dipromosikan menjadi dokter spesialis',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'pegawai_id'      => 2, // Siti Rahma
                'sub_jabatan_id'  => 3, // Perawat IGD
                'tanggal_mulai'   => Carbon::now()->subMonths(18)->format('Y-m-d'),
                'tanggal_selesai' => Carbon::now()->subMonths(6)->format('Y-m-d'),
                'keterangan'      => 'Perawat shift malam di IGD',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'pegawai_id'      => 2,
                'sub_jabatan_id'  => 4, // Perawat Rawat Inap (misal)
                'tanggal_mulai'   => Carbon::now()->subMonths(6)->format('Y-m-d'),
                'tanggal_selesai' => null,
                'keterangan'      => 'Dipindah ke ruang rawat inap',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'pegawai_id'      => 3, // Budi Santoso
                'sub_jabatan_id'  => 5, // Satpam Pintu Utama
                'tanggal_mulai'   => Carbon::now()->subYears(3)->format('Y-m-d'),
                'tanggal_selesai' => null,
                'keterangan'      => 'Ditempatkan di pintu utama',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
        ]);
    }
}
