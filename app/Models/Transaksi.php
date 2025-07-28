<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\PegawaiTetap; // Import model PegawaiTetap
use App\Models\PegawaiTidakTetap; // Import model PegawaiTidakTetap
use App\Models\BukanPegawai; // Import model BukanPegawai

class Transaksi extends Model
{
    /** @use HasFactory<\Database\Factories\TransaksiFactory> */
    use HasFactory;

    protected $fillable = ['total','pengguna_id','status_pembayaran','metode_pembayaran,','tanggal_pembayaran', 'jenis_pegawai'];

    /**
     * Relasi ke model Pengguna (user).
     */
    public function penggunas(){
        return $this->belongsTo(Pengguna::class);
    }

    // public function transaksiable()
    // {
    //     return $this->morphTo();
    // }

    /**
     * Relasi satu-ke-satu ke model PegawaiTetap.
     * Transaksi ini mungkin terkait dengan satu perhitungan PegawaiTetap.
     */
    public function pegawaiTetap()
    {
        return $this->hasOne(PegawaiTetap::class, 'transaksi_id');
    }

    /**
     * Relasi satu-ke-satu ke model PegawaiTidakTetap.
     * Transaksi ini mungkin terkait dengan satu perhitungan PegawaiTidakTetap.
     */
    public function pegawaiTidakTetap()
    {
        return $this->hasOne(PegawaiTidakTetap::class, 'transaksi_id');
    }

    /**
     * Relasi satu-ke-satu ke model BukanPegawai.
     * Transaksi ini mungkin terkait dengan satu perhitungan BukanPegawai.
     */
    public function bukanPegawai()
    {
        return $this->hasOne(BukanPegawai::class, 'transaksi_id');
    }
}
