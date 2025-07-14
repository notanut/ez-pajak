<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PegawaiTetap;
use App\Models\Pengguna;
use App\Models\Transaksi;

class PegawaiTetapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $rahmat = Pengguna::where('nama','Rahmat')->first();
        $violet = Pengguna::where('nama','Violet')->first();

        $pegawaiTetap1 = PegawaiTetap::create(['role'=> 'Hai aku PT1']);
        $pegawaiTetap2 = PegawaiTetap::create(['role'=> 'Hai aku PT12']);


    //     $pegawaiTetap1->transaksis()->create([
    //         'total' => '2400000',
    //         'pengguna_id' => $rahmat->id,
    //         'status_pembayaran' => 1,
    //         'metode_pembayaran'=> 'Gopay',
    //         'tanggal_pembayaran' => '2025-7-1'
    //     ]);

    //     $pegawaiTetap2->transaksis()->create([
    //         'total' => '1200000',
    //         'pengguna_id' => $violet->id,
    //         'status_pembayaran' => 0,
    //         'metode_pembayaran'=> 'OVO',
    //         'tanggal_pembayaran' => '2025-7-2'
    //     ]);
    }
}
