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

        // 1. Buat transaksi terlebih dahulu untuk mendapatkan ID-nya
        $transaksi = Transaksi::create([
            'pengguna_id' => $user->id,
            'total' => $request->pph21_terutang,
            'status_pembayaran' => false,
            'metode_pembayaran' => 'belum',
            'tanggal_pembayaran' => now(),
            'jenis_pegawai' => 'Pegawai Tetap', // Set jenis_pegawai
        ]);

        // 2. Kemudian buat record PegawaiTetap dan kaitkan dengan transaksi yang baru dibuat
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
            'transaksi_id' => $transaksi->id, // Kaitkan dengan ID transaksi yang baru dibuat
        ]);

        // $user->pegawaitetap()->save($pegawai);

        return response()->json([
            'success' => true,
            'user_id' => $user->id,
            'transaksi_id' => $transaksi->id
        ]);
    }

    /**
     * Menampilkan formulir untuk mengedit data Pegawai Tetap.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\View\View
     */
    public function edit(Transaksi $transaksi)
    {
        // Pastikan transaksi ini milik pengguna yang sedang login dan jenisnya sesuai
        if ($transaksi->pengguna_id !== Auth::id() || $transaksi->jenis_pegawai !== 'Pegawai Tetap') {
            abort(403, 'Unauthorized action.');
        }

        // Ambil data PegawaiTetap yang terkait dengan transaksi ini
        $pegawaiTetap = PegawaiTetap::where('transaksi_id', $transaksi->id)->firstOrFail();
        $pengguna = Auth::user();

        // Kirim data ke view
        return view('calculator.index', compact('pegawaiTetap', 'transaksi', 'pengguna'));
    }

    /**
     * Memperbarui data Pegawai Tetap di penyimpanan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        // Pastikan transaksi ini milik pengguna yang sedang login dan jenisnya sesuai
        if ($transaksi->pengguna_id !== Auth::id() || $transaksi->jenis_pegawai !== 'Pegawai Tetap') {
            abort(403, 'Unauthorized action.');
        }

        $user = Auth::user();

        // Validasi data yang masuk
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

            // Hasil Perhitungan
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

        // Temukan data PegawaiTetap yang terkait dengan transaksi ini
        $pegawaiTetap = PegawaiTetap::where('transaksi_id', $transaksi->id)->firstOrFail();

        // Perbarui data PegawaiTetap
        $pegawaiTetap->update([
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

        // Perbarui total transaksi
        $transaksi->update([
            'total' => $request->pph21_terutang,
        ]);

        return response()->json([
            'success' => true,
            'user_id' => $user->id,
            'message' => 'Data Pegawai Tetap dan Transaksi berhasil diperbarui.',
        ]);
    }
}
