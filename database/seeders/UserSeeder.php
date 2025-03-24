<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tuser')->insert([
            'username'    => 'admin',
            'password'    => bcrypt('admin123'),
            'role'        => 'admin',
            'staff_id'    => '2'
        ]);
    }
}
