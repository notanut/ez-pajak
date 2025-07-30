<?php

namespace App\Http\Controllers;

use App\Models\PegawaiTidakTetap;
use App\Http\Requests\StorepegawaiTidakTetapRequest;
use App\Http\Requests\UpdatepegawaiTidakTetapRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PegawaiTetap;
use App\Models\Transaksi;
use Illuminate\Validation\Rule;

class PegawaiTidakTetapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'jenis_kelamin' => 'required|in:Pria,Wanita',
            'status_perkawinan' => 'required|in:Kawin,Tidak Kawin,Hidup Berpisah',
            'tanggungan' => 'required|integer|min:0|max:3',
            'dibayar_bulanan' => 'required|boolean',
            'bulanan_sama' => 'required_if:dibayar_bulanan,1|boolean',
            'metode_penghitungan' => 'required|string',
            'pph21_terutang' => 'required|numeric|min:0',

            'bruto_perbulan' => [
            'nullable', 'numeric', 'min:1',
            Rule::requiredIf(fn() => $request->dibayar_bulanan == 1 && $request->bulanan_sama == 1),
            ],
            'banyak_bulan_bekerja' => [
            'nullable', 'integer', 'min:1', 'max:12',
            Rule::requiredIf(fn() => $request->dibayar_bulanan == 1 && $request->bulanan_sama == 1),
            ],
            'pph21_perbulan' => 'nullable|numeric|min:0',

            'bruto_jan' => 'nullable|numeric|min:0',
            'bruto_feb' => 'nullable|numeric|min:0',
            'bruto_mar' => 'nullable|numeric|min:0',
            'bruto_apr' => 'nullable|numeric|min:0',
            'bruto_mei' => 'nullable|numeric|min:0',
            'bruto_jun' => 'nullable|numeric|min:0',
            'bruto_jul' => 'nullable|numeric|min:0',
            'bruto_agu' => 'nullable|numeric|min:0',
            'bruto_sep' => 'nullable|numeric|min:0',
            'bruto_okt' => 'nullable|numeric|min:0',
            'bruto_nov' => 'nullable|numeric|min:0',
            'bruto_des' => 'nullable|numeric|min:0',

            'pajak_jan' => 'nullable|numeric|min:0',
            'pajak_feb' => 'nullable|numeric|min:0',
            'pajak_mar' => 'nullable|numeric|min:0',
            'pajak_apr' => 'nullable|numeric|min:0',
            'pajak_mei' => 'nullable|numeric|min:0',
            'pajak_jun' => 'nullable|numeric|min:0',
            'pajak_jul' => 'nullable|numeric|min:0',
            'pajak_agu' => 'nullable|numeric|min:0',
            'pajak_sep' => 'nullable|numeric|min:0',
            'pajak_okt' => 'nullable|numeric|min:0',
            'pajak_nov' => 'nullable|numeric|min:0',
            'pajak_des' => 'nullable|numeric|min:0',

            'total_bruto' => [
            'nullable', 'numeric', 'min:1',
            Rule::requiredIf(fn() => $request->dibayar_bulanan == 0),
            ],
            'lama_hari_bekerja' => 'nullable|integer|min:1',
            'avg_bruto' => 'nullable|numeric|min:0',
            'pph21_perhari' => 'nullable|numeric|min:0',
        ]);

        if ($request->dibayar_bulanan && !$request->bulanan_sama) {
            $bulanFields = [
            'bruto_jan', 'bruto_feb', 'bruto_mar', 'bruto_apr', 'bruto_mei',
            'bruto_jun', 'bruto_jul', 'bruto_agu', 'bruto_sep',
            'bruto_okt', 'bruto_nov', 'bruto_des'
            ];

            $jumlahYangTerisi = collect($bulanFields)
            ->map(fn($b) => (float) $request->input($b, 0))
            ->filter(fn($val) => $val > 0)
            ->count();

            if ($jumlahYangTerisi === 0) {
            return response()->json([
                'errors' => [
                'bruto_jan' => ['Minimal 1 bulan penghasilan harus diisi jika penghasilan bulanan tidak sama.']
                ]
            ], 422);
            }
        }

        // Buat transaksi terlebih dahulu untuk mendapatkan ID-nya
        $transaksi = Transaksi::create([
            'pengguna_id' => $user->id,
            'total' => $request->pph21_terutang,
            'status_pembayaran' => false,
            'metode_pembayaran' => 'belum',
            'tanggal_pembayaran' => now(),
            'jenis_pegawai' => 'Pegawai Tidak Tetap', // Set jenis_pegawai
        ]);

        // Buat record PegawaiTidakTetap dan kaitkan dengan transaksi
        $pegawai = PegawaiTidakTetap::create([
            'pengguna_id' => $user->id,
            'role' => 'Pegawai Tidak Tetap',
            'jenis_kelamin' => $request->jenis_kelamin,
            'status_perkawinan' => $request->status_perkawinan,
            'tanggungan' => $request->tanggungan,
            'bulanan_sama' => $request->bulanan_sama,
            'bruto_perbulan' => $request->bruto_perbulan,
            'banyak_bulan_bekerja' => $request->banyak_bulan_bekerja,
            'bruto_jan' => $request->bruto_jan,
            'bruto_feb' => $request->bruto_feb,
            'bruto_mar' => $request->bruto_mar,
            'bruto_apr' => $request->bruto_apr,
            'bruto_mei' => $request->bruto_mei,
            'bruto_jun' => $request->bruto_jun,
            'bruto_jul' => $request->bruto_jul,
            'bruto_agu' => $request->bruto_agu,
            'bruto_sep' => $request->bruto_sep,
            'bruto_okt' => $request->bruto_okt,
            'bruto_nov' => $request->bruto_nov,
            'bruto_des' => $request->bruto_des,
            'total_bruto' => $request->total_bruto,
            'lama_hari_bekerja' => $request->lama_hari_bekerja,
            'avg_bruto' => $request->avg_bruto,
            'metode_penghitungan' => $request->metode_penghitungan,
            'pph21_terutang' => $request->pph21_terutang,
            'pph21_perbulan' => $request->pph21_perbulan,
            'pph21_perhari' => $request->pph21_perhari,
            'pajak_jan' => $request->pajak_jan,
            'pajak_feb' => $request->pajak_feb,
            'pajak_mar' => $request->pajak_mar,
            'pajak_apr' => $request->pajak_apr,
            'pajak_mei' => $request->pajak_mei,
            'pajak_jun' => $request->pajak_jun,
            'pajak_jul' => $request->pajak_jul,
            'pajak_agu' => $request->pajak_agu,
            'pajak_sep' => $request->pajak_sep,
            'pajak_okt' => $request->pajak_okt,
            'pajak_nov' => $request->pajak_nov,
            'pajak_des' => $request->pajak_des,
            'transaksi_id' => $transaksi->id, // Pengait dengan ID transaksi yang baru dibuat
        ]);


        return response()->json([
            'success' => true,
            'user_id' => $user->id,
            'transaksi_id' => $transaksi->id
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(pegawaiTidakTetap $pegawaiTidakTetap)
    {
        //
    }

    /**
     * Menampilkan formulir untuk mengedit data Pegawai Tidak Tetap.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\View\View
     */
    public function edit(Transaksi $transaksi)
    {
        if ($transaksi->pengguna_id !== Auth::id() || $transaksi->jenis_pegawai !== 'Pegawai Tidak Tetap') {
            abort(403, 'Unauthorized action.');
        }

        // Ambil data PegawaiTidakTetap yang terkait dengan transaksi ini
        $pegawaiTidakTetap = PegawaiTidakTetap::where('transaksi_id', $transaksi->id)->firstOrFail();
        $pengguna = Auth::user();

        // Kirim data ke view
        return view('calculator.pegawaiTidakTetap', compact('pegawaiTidakTetap', 'transaksi', 'pengguna'));
    }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(UpdatepegawaiTidakTetapRequest $request, pegawaiTidakTetap $pegawaiTidakTetap)
    // {
    //     //
    // }

    /**
     * Memperbarui data Pegawai Tidak Tetap di penyimpanan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        // Pastikan transaksi ini milik pengguna yang sedang login dan jenisnya sesuai
        if ($transaksi->pengguna_id !== Auth::id() || $transaksi->jenis_pegawai !== 'Pegawai Tidak Tetap') {
            abort(403, 'Unauthorized action.');
        }

        $user = Auth::user();

        // Validasi data yang masuk
        $request->validate([
            'jenis_kelamin' => 'required|in:Pria,Wanita',
            'status_perkawinan' => 'required|in:Kawin,Tidak Kawin,Hidup Berpisah',
            'tanggungan' => 'required|integer|min:0|max:3',
            'dibayar_bulanan' => 'required|boolean',
            'bulanan_sama' => 'required_if:dibayar_bulanan,1|boolean',
            'metode_penghitungan' => 'required|string',
            'pph21_terutang' => 'required|numeric|min:0',

            'bruto_perbulan' => [
                'nullable', 'numeric', 'min:1',
                Rule::requiredIf(fn() => $request->dibayar_bulanan == 1 && $request->bulanan_sama == 1),
            ],
            'banyak_bulan_bekerja' => [
                'nullable', 'integer', 'min:1', 'max:12',
                Rule::requiredIf(fn() => $request->dibayar_bulanan == 1 && $request->bulanan_sama == 1),
            ],
            'pph21_perbulan' => 'nullable|numeric|min:0',

            'bruto_jan' => 'nullable|numeric|min:0',
            'bruto_feb' => 'nullable|numeric|min:0',
            'bruto_mar' => 'nullable|numeric|min:0',
            'bruto_apr' => 'nullable|numeric|min:0',
            'bruto_mei' => 'nullable|numeric|min:0',
            'bruto_jun' => 'nullable|numeric|min:0',
            'bruto_jul' => 'nullable|numeric|min:0',
            'bruto_agu' => 'nullable|numeric|min:0',
            'bruto_sep' => 'nullable|numeric|min:0',
            'bruto_okt' => 'nullable|numeric|min:0',
            'bruto_nov' => 'nullable|numeric|min:0',
            'bruto_des' => 'nullable|numeric|min:0',

            'pajak_jan' => 'nullable|numeric|min:0',
            'pajak_feb' => 'nullable|numeric|min:0',
            'pajak_mar' => 'nullable|numeric|min:0',
            'pajak_apr' => 'nullable|numeric|min:0',
            'pajak_mei' => 'nullable|numeric|min:0',
            'pajak_jun' => 'nullable|numeric|min:0',
            'pajak_jul' => 'nullable|numeric|min:0',
            'pajak_agu' => 'nullable|numeric|min:0',
            'pajak_sep' => 'nullable|numeric|min:0',
            'pajak_okt' => 'nullable|numeric|min:0',
            'pajak_nov' => 'nullable|numeric|min:0',
            'pajak_des' => 'nullable|numeric|min:0',

            'total_bruto' => [
                'nullable', 'numeric', 'min:1',
                Rule::requiredIf(fn() => $request->dibayar_bulanan == 0),
            ],
            'lama_hari_bekerja' => [
                'nullable', 'integer', 'min:1',
                Rule::requiredIf(fn() => $request->dibayar_bulanan == 0),
            ],
            'avg_bruto' => 'nullable|numeric|min:0',
            'pph21_perhari' => 'nullable|numeric|min:0',
        ]);

        if ($request->dibayar_bulanan && !$request->bulanan_sama) {
            $bulanFields = [
                'bruto_jan', 'bruto_feb', 'bruto_mar', 'bruto_apr', 'bruto_mei',
                'bruto_jun', 'bruto_jul', 'bruto_agu', 'bruto_sep',
                'bruto_okt', 'bruto_nov', 'bruto_des'
            ];

            $jumlahYangTerisi = collect($bulanFields)
                ->map(fn($b) => (float) $request->input($b, 0))
                ->filter(fn($val) => $val > 0)
                ->count();

            if ($jumlahYangTerisi === 0) {
                return response()->json([
                    'errors' => [
                        'bruto_jan' => ['Minimal 1 bulan penghasilan harus diisi jika penghasilan bulanan tidak sama.']
                    ]
                ], 422);
            }
        }

        // Temukan data PegawaiTidakTetap yang terkait dengan transaksi ini
        $pegawaiTidakTetap = PegawaiTidakTetap::where('transaksi_id', $transaksi->id)->firstOrFail();

        // Perbarui data PegawaiTidakTetap
        $pegawaiTidakTetap->update([
            'jenis_kelamin' => $request->jenis_kelamin,
            'status_perkawinan' => $request->status_perkawinan,
            'tanggungan' => $request->tanggungan,
            'bulanan_sama' => $request->bulanan_sama,
            'bruto_perbulan' => $request->bruto_perbulan,
            'banyak_bulan_bekerja' => $request->banyak_bulan_bekerja,
            'bruto_jan' => $request->bruto_jan,
            'bruto_feb' => $request->bruto_feb,
            'bruto_mar' => $request->bruto_mar,
            'bruto_apr' => $request->bruto_apr,
            'bruto_mei' => $request->bruto_mei,
            'bruto_jun' => $request->bruto_jun,
            'bruto_jul' => $request->bruto_jul,
            'bruto_agu' => $request->bruto_agu,
            'bruto_sep' => $request->bruto_sep,
            'bruto_okt' => $request->bruto_okt,
            'bruto_nov' => $request->bruto_nov,
            'bruto_des' => $request->bruto_des,
            'total_bruto' => $request->total_bruto,
            'lama_hari_bekerja' => $request->lama_hari_bekerja,
            'avg_bruto' => $request->avg_bruto,
            'metode_penghitungan' => $request->metode_penghitungan,
            'pph21_terutang' => $request->pph21_terutang,
            'pph21_perbulan' => $request->pph21_perbulan,
            'pph21_perhari' => $request->pph21_perhari,
            'pajak_jan' => $request->pajak_jan,
            'pajak_feb' => $request->pajak_feb,
            'pajak_mar' => $request->pajak_mar,
            'pajak_apr' => $request->pajak_apr,
            'pajak_mei' => $request->pajak_mei,
            'pajak_jun' => $request->pajak_jun,
            'pajak_jul' => $request->pajak_jul,
            'pajak_agu' => $request->pajak_agu,
            'pajak_sep' => $request->pajak_sep,
            'pajak_okt' => $request->pajak_okt,
            'pajak_nov' => $request->pajak_nov,
            'pajak_des' => $request->pajak_des,
        ]);

        // Perbarui total transaksi
        $transaksi->update([
            'total' => $request->pph21_terutang,
        ]);

        return response()->json([
            'success' => true,
            'user_id' => $user->id,
            'message' => 'Data Pegawai Tidak Tetap dan Transaksi berhasil diperbarui.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(pegawaiTidakTetap $pegawaiTidakTetap)
    {
        //
    }
}
