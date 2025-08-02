<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NotificationLog;
use App\Models\Transaksi;

class HomeController extends Controller
{
    public function index()
    {
        // Mendapatkan ID pengguna yang sedang login
        $userId = auth()->id();

        // Ambil transaksi terbaru yang belum dibayar untuk pengguna yang sedang login
        $latestUnpaidTransaction = Transaksi::where('pengguna_id', $userId)
                                           ->where('status_pembayaran', 0)
                                           ->latest()
                                           ->first();

        // Variabel baru untuk countdown card, berisi objek transaksi atau null
        $transaksiCountdown = $latestUnpaidTransaction;
        // Ambil total untuk card "Jumlah Pembayaran" (bisa dari transaksi yg sama)
        $jumlahPembayaranPajak = $latestUnpaidTransaction?->total ?? 0;

        // Ambil transaksi terbaru APAPUN (baik sudah dibayar atau belum)
        // Ini untuk memastikan tombol edit selalu mengarah ke perhitungan terakhir
        $latestAnyTransaction = Transaksi::where('pengguna_id', $userId)
                                        ->latest()
                                        ->first();

        // Tentukan jenis pegawai dan ID transaksi untuk tombol edit
        // Prioritaskan transaksi yang belum dibayar, jika tidak ada, gunakan transaksi terbaru apapun
        $jenisPegawaiTerakhir = $latestUnpaidTransaction?->jenis_pegawai ?? $latestAnyTransaction?->jenis_pegawai ?? null;
        $latestTransactionId = $latestUnpaidTransaction?->id ?? $latestAnyTransaction?->id ?? null;



        // Mendapatkan objek pengguna yang sedang login
        $pengguna = Auth::user();

        // Kirim $jumlahPembayaranPajak, $jenisPegawaiTerakhir, $latestTransactionId, dan $pengguna ke view

        $notif = NotificationLog::all();
        return view('home.index', compact(
            'jumlahPembayaranPajak',
            'pengguna',
            'jenisPegawaiTerakhir',
            'latestTransactionId',
            'transaksiCountdown',
            'notif'
        ));
    }
}
