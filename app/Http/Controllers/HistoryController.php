<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index($id)
    {
        // Ambil data pembayaran
        $Transaksi = Transaksi::where('pengguna_id', $id)->get(); // Anda bisa menambahkan kondisi untuk user tertentu
        // $perhitungan = Perhitungan::find($id);
        // Kirim data ke view
        return view('history',compact('Transaksi'));
    }

    public function download($id)
    {
        $perhitungan = Perhitungan::find($id);

        // Pastikan file ada
        if ($perhitungan && file_exists(storage_path('app/public/' . $perhitungan->file_path))) {
            return response()->download(storage_path('app/public/' . $perhitungan->file_path));
        }

        return redirect()->back()->with('error', 'File tidak ditemukan.');
    }
}

