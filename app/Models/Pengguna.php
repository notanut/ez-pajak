<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    /** @use HasFactory<\Database\Factories\PenggunaFactory> */
    use HasFactory;

    protected $fillable = ['nama','email','password','jenis_pekerjaan','penghasilan_bruto','penghasilan_neto'];

    public function transaksis(){
        return $this->hasMany(Transaksi::class);
    }

}

