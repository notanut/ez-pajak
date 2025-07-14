<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        // return view('home.index');
        $userId = auth()->id();

        $pajakTetap = \App\Models\PegawaiTetap::where('pengguna_id', $userId)->first();
        $pajakTidakTetap = \App\Models\PegawaiTidakTetap::where('pengguna_id', $userId)->first();
        $pajakBukan = \App\Models\BukanPegawai::where('pengguna_id', $userId)->first();

        $data = collect([$pajakTetap, $pajakTidakTetap, $pajakBukan])
                    ->filter()
                    ->sortByDesc('updated_at')
                    ->first();

        $jumlahPajak = $data?->pph21_terutang ?? 0;

        return view('home.index', compact('jumlahPajak'));
        }
}
