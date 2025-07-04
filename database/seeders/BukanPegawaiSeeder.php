<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BukanPegawai;
use App\Models\Pengguna;
use App\Models\Transaksi;

class BukanPegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $rahmat = Pengguna::where('nama','Rahmat')->first();
        $violet = Pengguna::where('nama','Violet')->first();

        $bukanPegawai1 = BukanPegawai::create(['role'=> 'Hai aku BP1']);
        $bukanPegawai2 = BukanPegawai::create(['role'=> 'Hai aku BP2']);


        // $bukanPegawai1->transaksis()->create([
        //     'total' => '2400000',
        //     'pengguna_id' => $rahmat->id,
        //     'status_pembayaran' => 1,
        //     'metode_pembayaran'=> 'Gopay',
        //     'tanggal_pembayaran' => '2025-7-1'
        // ]);

        // $bukanPegawai2->transaksis()->create([
        //     'total' => '1200000',
        //     'pengguna_id' => $violet->id,
        //     'status_pembayaran' => 0,
        //     'metode_pembayaran'=> 'OVO',
        //     'tanggal_pembayaran' => '2025-7-2'
        // ]);

    }
}
