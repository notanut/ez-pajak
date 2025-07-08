<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengguna;
use App\Models\Transaksi;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $rahmat = Pengguna::where('nama','Rahmat')->first();
        $violet = Pengguna::where('nama','Violet')->first();


        Transaksi::create([
            'pengguna_id' => $rahmat->id,
            'total' => 25000000,
            'status_pembayaran' => false,
            'metode_pembayaran' => 'belum',
            'tanggal_pembayaran' => now(),
        ]);

        Transaksi::create([
            'pengguna_id' => $violet->id,
            'total' => 250000000,
            'status_pembayaran' => true,
            'metode_pembayaran' => 'belum',
            'tanggal_pembayaran' => now(),
        ]);

    }
}
