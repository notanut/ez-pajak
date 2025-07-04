<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\PenggunaFactory> */
    use HasFactory;

    protected $fillable = [
    'nama',
    'email',
    'password'
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function pegawaitetap()
    {
        return $this->hasOne(PegawaiTetap::class);
    }
    public function pegawaitidaktetap()
    {
        return $this->hasOne(PegawaiTetap::class);
    }
    public function bukanpegawai()
    {
        return $this->hasOne(PegawaiTetap::class);
    }

}

