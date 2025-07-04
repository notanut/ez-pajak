<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengguna;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Pengguna::create([
        'nama' => 'Rahmat',
        'email' => 'rahmat@gmail.com',
        'password' => '12345',
        ]);

        Pengguna::create([
        'nama' => 'Violet',
        'email' => 'violet@gmail.com',
        'password' => '54321',
        ]);

    }
}
