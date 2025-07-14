<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PegawaiTetap;
use App\Models\Transaksi;
use App\Models\Pengguna;
use Carbon\Carbon;

class PegawaiTetapController extends Controller
{

    public function create(){
        $pengguna = Auth::user();

        return view('calculator.index',compact('pengguna'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'jenis_kelamin' => 'required|in:Pria,Wanita',
            'tanggungan' => 'required|integer|min:0|max:3',
            'status_perkawinan' => 'required|in:Kawin,Tidak Kawin,Hidup Berpisah',
            'masa_awal' => ['required', 'date'],
            'masa_akhir' => ['required', 'date', 'after_or_equal:masa_awal'],
            'disetahunkan' => 'required|boolean',

            // Penghasilan
            'gaji' => 'required|numeric|gt:0',
            'tunjangan_pph' => 'required|numeric|min:0',
            'tunjangan_lain' => 'required|numeric|min:0',
            'honor' => 'required|numeric|min:0',
            'premi' => 'required|numeric|min:0',
            'natura' => 'required|numeric|min:0',
            'tantiem' => 'required|numeric|min:0',

            // Pengurangan
            'biaya_jabatan' => 'required|numeric|min:0',
            'iuran_pensiun' => 'required|numeric|min:0',
            'zakat' => 'required|numeric|min:0',

            // Hasil perhitungan
            'penghasilan_bruto' => 'required|numeric|min:0',
            'pengurangan' => 'required|numeric|min:0',
            'penghasilan_neto' => 'required|numeric|min:0',
            'penghasilan_neto_masa_sebelumnya' => 'required|numeric|min:0',
            'penghasilan_neto_pph21' => 'required|numeric|min:0',
            'ptkp' => 'required|numeric|min:0',
            'pkp' => 'required|numeric|min:0',
            'tarif_progresif' => 'required|string',
            'pph21_pkp' => 'required|numeric|min:0',
            'pph21_dipotong_masa_sebelum' => 'required|numeric|min:0',
            'pph21_terutang' => 'required|numeric|min:0',
        ]);

        $pegawai = PegawaiTetap::create([
            'pengguna_id' => $user->id,
            'role' => 'Pegawai Tetap',
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggungan' => $request->tanggungan,
            'status_perkawinan' => $request->status_perkawinan,
            'masa_penghasilan_awal' => $request->masa_awal,
            'masa_penghasilan_akhir' => $request->masa_akhir,
            'disetahunkan' => $request->disetahunkan,

            'gaji' => $request->gaji,
            'tunjangan_pph' => $request->tunjangan_pph,
            'tunjangan_lain' => $request->tunjangan_lain,
            'honor' => $request->honor,
            'premi' => $request->premi,
            'natura' => $request->natura,
            'tantiem' => $request->tantiem,

            'biaya_jabatan' => $request->biaya_jabatan,
            'iuran_pensiun' => $request->iuran_pensiun,
            'zakat' => $request->zakat,
            'penghasilan_bruto' => $request->penghasilan_bruto,
            'pengurangan' => $request->pengurangan,
            'penghasilan_neto' => $request->penghasilan_neto,
            'penghasilan_neto_masa_sebelumnya' => $request->penghasilan_neto_masa_sebelumnya,
            'penghasilan_neto_pph21' => $request->penghasilan_neto_pph21,
            'ptkp' => $request->ptkp,
            'pkp' => $request->pkp,
            'tarif_progresif' => $request->tarif_progresif,
            'pph21_pkp' => $request->pph21_pkp,
            'pph21_dipotong_masa_sebelum' => $request->pph21_dipotong_masa_sebelum,
            'pph21_terutang' => $request->pph21_terutang,
        ]);

        // $user->pegawaitetap()->save($pegawai);

        // Buat transaksi
        Transaksi::create([
            'pengguna_id' => $user->id,
            'total' => $request->pph21_terutang,
            'status_pembayaran' => false,
            'metode_pembayaran' => 'belum',
            'tanggal_pembayaran' => now(),
        ]);

        return response()->json([
            'success' => true,
            'user_id' => $user->id,
        ]);
    }
}
