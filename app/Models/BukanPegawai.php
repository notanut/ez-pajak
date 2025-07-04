<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukanPegawai extends Model
{
    /** @use HasFactory<\Database\Factories\BukanPegawaiFactory> */
    use HasFactory;

    protected $fillable = [
        'role',
        'pengguna_id',
        'dibayar_bulanan',
        'bulanan_sama',

        // bulanan tetap
        'bruto_perbulan',
        'banyak_bulan_bekerja',

        // bulanan tidak tetap
        'bruto_jan',
        'bruto_feb',
        'bruto_mar',
        'bruto_apr',
        'bruto_mei',
        'bruto_jun',
        'bruto_jul',
        'bruto_agut',
        'bruto_sept',
        'bruto_okt',
        'bruto_nov',
        'bruto_des',

        // tidak bulanan
        'total_bruto',
        'pihak_ketiga',
        'biaya_pihak_ketiga',

        // hasil penghitungan
        'metode_penghitungan',
        'pph21_terutang',
        'tarif',
        'pph21_perbulan',

        // bulanan tidak tetap - pajak tiap bulan
        'pajak_jan',
        'pajak_feb',
        'pajak_mar',
        'pajak_apr',
        'pajak_mei',
        'pajak_jun',
        'pajak_jul',
        'pajak_agt',
        'pajak_sept',
        'pajak_okt',
        'pajak_nov',
        'pajak_des',

        // tidak bulanan
        'penghasilan_neto',
    ];

    // public function transaksis()
    // {
    //     return $this->morphMany(Transaksi::class, 'transaksiable');
    // }

    public function penggunas()
    {
        return $this->belongsTo(Pengguna::class);
    }

}
