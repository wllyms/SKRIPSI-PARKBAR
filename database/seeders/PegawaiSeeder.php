<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pegawai')->insert([
            [
                'kode_member'     => 'MBR-' . Str::upper(Str::random(5)),
                'plat_kendaraan'  => 'DA1234AB',
                'nama'            => 'Dr. Andi Pratama',
                'no_telp'         => '081234567890',
                'email'           => 'andi.pratama@example.com',
                'alamat'          => 'Jl. Sultan Adam No. 10, Banjarmasin',
                'merk_kendaraan'  => 'Toyota Avanza',
                'image'           => 'default.png', // asumsikan default image
                'jabatan_id'      => 1, // Dokter
                'sub_jabatan_id'  => 1, // Dokter Umum
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'kode_member'     => 'MBR-' . Str::upper(Str::random(5)),
                'plat_kendaraan'  => 'DA5678CD',
                'nama'            => 'Siti Rahma',
                'no_telp'         => '082212345678',
                'email'           => 'siti.rahma@example.com',
                'alamat'          => 'Jl. A. Yani KM.5, Banjarmasin',
                'merk_kendaraan'  => 'Honda Beat',
                'image'           => 'default.png',
                'jabatan_id'      => 2, // Perawat
                'sub_jabatan_id'  => 3, // Perawat IGD
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'kode_member'     => 'MBR-' . Str::upper(Str::random(5)),
                'plat_kendaraan'  => 'DA9999EF',
                'nama'            => 'Budi Santoso',
                'no_telp'         => '085334455667',
                'email'           => 'budi.santoso@example.com',
                'alamat'          => 'Jl. Veteran No. 7, Banjarmasin',
                'merk_kendaraan'  => 'Yamaha Mio',
                'image'           => 'default.png',
                'jabatan_id'      => 3, // Petugas Keamanan
                'sub_jabatan_id'  => 5, // Satpam Pintu Utama
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
        ]);
    }
}
