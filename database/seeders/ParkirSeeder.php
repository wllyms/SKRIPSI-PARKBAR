<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ParkirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan tabel relasi memiliki data terlebih dahulu
        // Misalnya, Anda harus memiliki data di tabel `tarif`, `slot_parkir`, dan `tuser`
        // Sebelum menjalankan seeder ini.
        $tarifIds = DB::table('tarif')->pluck('id')->toArray();
        $slotParkirIds = DB::table('slot_parkir')->pluck('id')->toArray();
        $userIds = DB::table('tuser')->pluck('id')->toArray();

        // Pastikan tabel relasi tidak kosong
        if (empty($tarifIds) || empty($slotParkirIds) || empty($userIds)) {
            $this->command->info('Pastikan tabel `tarif`, `slot_parkir`, dan `tuser` sudah memiliki data sebelum menjalankan seeder ini.');
            return;
        }

        $data = [];
        for ($i = 0; $i < 10; $i++) {
            $waktuMasuk = Carbon::now()->subDays(rand(1, 30))->subHours(rand(1, 24));
            $waktuKeluar = $waktuMasuk->copy()->addHours(rand(1, 5));
            $durasi = $waktuMasuk->diffInMinutes($waktuKeluar);

            $data[] = [
                'kode_parkir' => 'PK-' . Str::random(8),
                'plat_kendaraan' => $this->generateRandomPlate(),
                'tarif_id' => $tarifIds[array_rand($tarifIds)],
                'slot_parkir_id' => $slotParkirIds[array_rand($slotParkirIds)],
                'user_id' => $userIds[array_rand($userIds)],
                'waktu_masuk' => $waktuMasuk,
                'waktu_keluar' => $waktuKeluar,
                'durasi' => $durasi,
                'status' => 'Keluar',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Tambahkan beberapa data dengan status 'Terparkir'
        for ($i = 0; $i < 5; $i++) {
            $data[] = [
                'kode_parkir' => 'PK-' . Str::random(8),
                'plat_kendaraan' => $this->generateRandomPlate(),
                'tarif_id' => $tarifIds[array_rand($tarifIds)],
                'slot_parkir_id' => $slotParkirIds[array_rand($slotParkirIds)],
                'user_id' => $userIds[array_rand($userIds)],
                'waktu_masuk' => Carbon::now()->subMinutes(rand(10, 60)),
                'waktu_keluar' => null,
                'durasi' => null,
                'status' => 'Terparkir',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('parkir')->insert($data);
    }

    /**
     * Generate a random Indonesian-style license plate.
     */
    private function generateRandomPlate(): string
    {
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $prefix = substr(str_shuffle($letters), 0, 2);
        $numericPart = substr(str_shuffle($numbers), 0, 4);
        $suffix = substr(str_shuffle($letters), 0, 2);
        return "$prefix $numericPart $suffix";
    }
}
