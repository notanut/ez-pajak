<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    /** @use HasFactory<\Database\Factories\TransaksiFactory> */
    use HasFactory;

    protected $fillable = ['total','pengguna_id','status_pembayaran','metode_pembayaran,','tanggal_pembayaran'];

    public function penggunas(){
        return $this->belongsTo(Pengguna::class);
    }

}
