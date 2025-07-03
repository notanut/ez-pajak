<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PegawaiTidakTetap extends Model
{
    //
    public function transaksis()
    {
        return $this->morphMany(Transaksi::class, 'transaksiable');
    }

}
