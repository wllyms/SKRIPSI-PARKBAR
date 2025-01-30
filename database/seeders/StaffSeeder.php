<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('staff')->insert([
            'nama'    => 'Smith Willyams',
            'no_telp' => '081348209166',
            'alamat'  => 'Jl. Raya No. 12',
        ]);

        DB::table('staff')->insert([
            'nama'    => 'Hillary Abigail',
            'no_telp' => '081348209166',
            'alamat'  => 'Jl. Raya No. 13',
        ]);
    }
}
