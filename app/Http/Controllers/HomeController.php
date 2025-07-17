<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $pengguna = Auth::user();
        return view('home.index', compact('jumlahPajak','pengguna'));
        }
}
