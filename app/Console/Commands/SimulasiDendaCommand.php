<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Parkir;
use Carbon\Carbon;

class SimulasiDendaCommand extends Command
{
    protected $signature = 'parkir:test-denda {id} {jamLalu}';
    protected $description = 'Simulasi waktu_masuk mundur untuk testing denda';

    public function handle()
    {
        $id = $this->argument('id');
        $jamLalu = $this->argument('jamLalu');

        $parkir = Parkir::find($id);

        if (!$parkir) {
            $this->error("Parkir ID $id tidak ditemukan.");
            return;
        }

        $waktuBaru = now()->subHours($jamLalu);
        $parkir->waktu_masuk = $waktuBaru;
        $parkir->save();

        $this->info("Waktu masuk Parkir ID $id berhasil diubah menjadi: " . $waktuBaru);
    }
}
