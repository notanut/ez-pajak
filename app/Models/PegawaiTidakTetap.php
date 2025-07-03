<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pegawaiTidakTetap extends Model
{
    /** @use HasFactory<\Database\Factories\PegawaiTidakTetapFactory> */
    use HasFactory;
    public function transaksis()
    {
        return $this->morphMany(Transaksi::class, 'transaksiable');
    }

}
