<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiTetap extends Model
{
    /** @use HasFactory<\Database\Factories\PegawaiTetapFactory> */
    use HasFactory;

    protected $fillable = ['role', 'pengguna_id', 'jenis_kelamin', 'tanggungan', 'status_perkawinan', 'masa_penghasilan_awal', 'masa_penghasilan_akhir', 'disetahunkan', 'gaji', 'tunjangan_pph', 'tunjangan_lain', 'honor', 'premi', 'natura', 'tantiem', 'biaya_jabatan', 'iuran_pensiun', 'zakat', 'penghasilan_bruto', 'pengurangan', 'penghasilan_neto', 'penghasilan_neto_masa_sebelumnya', 'penghasilan_neto_pph21', 'ptkp', 'pkp', 'tarif_progresif', 'pph21_pkp', 'pph21_dipotong_masa_sebelum', 'pph21_terutang'];

    // public function transaksis()
    // {
    //     return $this->morphMany(Transaksi::class, 'transaksiable');
    // }

    public function penggunas()
    {
        return $this->belongsTo(Pengguna::class);
    }

}
