<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $table = 'penggunas';

    protected $fillable = [
        'nama',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Accessor untuk kompatibilitas dengan Breeze
    public function getNameAttribute()
    {
        return $this->nama;
    }

    // Mutator untuk kompatibilitas dengan Breeze
    public function setNameAttribute($value)
    {
        $this->attributes['nama'] = $value;
    }

    // Relasi
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
        return $this->hasOne(PegawaiTidakTetap::class);
    }

    public function bukanpegawai()
    {
        return $this->hasOne(BukanPegawai::class);
    }
}