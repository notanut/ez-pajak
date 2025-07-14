<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PegawaiTidakTetap;
use App\Models\Pengguna;
use App\Models\Transaksi;

class PegawaiTidakTetapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $rahmat = Pengguna::where('nama','Rahmat')->first();
        $violet = Pengguna::where('nama','Violet')->first();

        $ptt1 = PegawaiTidakTetap::create(['role'=> 'Hai aku PTT1']);
        $ptt2 = PegawaiTidakTetap::create(['role'=> 'Hai aku PTT2']);



        // $ptt1->transaksis()->create([
        //     'total' => '2400000',
        //     'pengguna_id' => $rahmat->id,
        //     'status_pembayaran' => 1,
        //     'metode_pembayaran'=> 'Gopay',
        //     'tanggal_pembayaran' => '2025-7-1'
        // ]);

        // $ptt2->transaksis()->create([
        //     'total' => '1200000',
        //     'pengguna_id' => $violet->id,
        //     'status_pembayaran' => 0,
        //     'metode_pembayaran'=> 'OVO',
        //     'tanggal_pembayaran' => '2025-7-2'
        // ]);
    }
}
