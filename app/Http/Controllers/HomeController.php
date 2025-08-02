<?php

namespace App\Http\Controllers;

use App\Models\Item;
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

        // Cek transaksi terakhir. Jika ada DAN statusnya belum lunas (0), tampilkan totalnya. Jika tidak, tampilkan 0.
        $jumlahPembayaranPajak = ($latestAnyTransaction && $latestAnyTransaction->status_pembayaran == 0) ? $latestAnyTransaction->total : 0;

        // Tentukan jenis pegawai dan ID transaksi untuk tombol edit
        // Prioritaskan transaksi yang belum dibayar, jika tidak ada, gunakan transaksi terbaru apapun
        $jenisPegawaiTerakhir = $latestUnpaidTransaction?->jenis_pegawai ?? $latestAnyTransaction?->jenis_pegawai ?? null;
        $latestTransactionId = $latestUnpaidTransaction?->id ?? $latestAnyTransaction?->id ?? null;

        // Tentukan apakah tombol edit harus muncul: HANYA jika transaksi terakhir ada DAN belum lunas.
        $showEditButton = ($latestAnyTransaction && $latestAnyTransaction->status_pembayaran == 0);

        // Mendapatkan objek pengguna yang sedang login
        $pengguna = Auth::user();

        // Kirim $jumlahPembayaranPajak, $jenisPegawaiTerakhir, $latestTransactionId, dan $pengguna ke view

        $notif = NotificationLog::where('pengguna_id',$userId)->get();
        return view('home.index', compact(
            'jumlahPembayaranPajak',
            'pengguna',
            'jenisPegawaiTerakhir',
            'latestTransactionId',
            'transaksiCountdown',
            'notif',
            'showEditButton'
        ));
    }

    public function deleteIndex(Request $request){

        $ids = $request->input('ids');

        if (!$ids || count($ids) === 0) {
            return back()->with('error', 'Tidak ada item yang dipilih.');
        }

        NotificationLog::whereIn('id', $ids)->delete();

        return back()->with('success', count($ids) . ' item berhasil dihapus.');

    }
}
