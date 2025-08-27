<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Pastikan tabel `jabatan` dan `sub_jabatan` sudah memiliki data
        // sebelum menjalankan seeder ini.
        $jabatanIds = DB::table('jabatan')->pluck('id')->toArray();
        $subJabatanIds = DB::table('sub_jabatan')->pluck('id')->toArray();

        // Cek apakah tabel relasi kosong.
        if (empty($jabatanIds) || empty($subJabatanIds)) {
            $this->command->info('Pastikan tabel `jabatan` dan `sub_jabatan` sudah memiliki data.');
            return;
        }

        $data = [];
        for ($i = 1; $i <= 15; $i++) {
            $namaLengkap = 'Pegawai ' . $i;
            $data[] = [
                'kode_member' => 'MBR-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'plat_kendaraan' => $this->generateRandomPlate(),
                'nama' => $namaLengkap,
                'no_telp' => '08' . mt_rand(100000000, 999999999),
                'email' => Str::slug(Str::words($namaLengkap, 1, '')) . $i . '@bhayangkara.polri.go.id',
                'alamat' => 'Jalan Damai No. ' . mt_rand(1, 100) . ', Banjarmasin',
                'merk_kendaraan' => $this->getRandomVehicleBrand(),
                'image' => 'images/pegawai/' . Str::slug($namaLengkap) . '.jpg', // Path ke gambar dummy
                'jabatan_id' => $jabatanIds[array_rand($jabatanIds)],
                'sub_jabatan_id' => $subJabatanIds[array_rand($subJabatanIds)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('pegawai')->insert($data);
    }

    /**
     * Generate a random Indonesian-style license plate.
     */
    private function generateRandomPlate(): string
    {
        $letters = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $numbers = '0123456789';
        $prefix = $letters[array_rand(str_split($letters))] . $letters[array_rand(str_split($letters))];
        $numericPart = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $suffix = $letters[array_rand(str_split($letters))];
        return "$prefix $numericPart $suffix";
    }

    /**
     * Get a random vehicle brand.
     */
    private function getRandomVehicleBrand(): string
    {
        $brands = ['Honda', 'Yamaha', 'Suzuki', 'Kawasaki', 'Toyota', 'Daihatsu', 'Mitsubishi', 'Nissan'];
        return $brands[array_rand($brands)];
    }
}
