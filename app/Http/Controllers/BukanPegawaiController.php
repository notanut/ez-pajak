<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BukanPegawai;
use App\Models\Pengguna;
use App\Models\Transaksi;
use App\Http\Requests\StoreBukanPegawaiRequest;
use App\Http\Requests\UpdateBukanPegawaiRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class BukanPegawaiController extends Controller
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
            'dibayar_bulanan' => 'required|boolean',
            'bulanan_sama' => 'required_if:dibayar_bulanan,1|boolean',
            'metode_penghitungan' => 'required|string',
            'tarif' => 'required|string',
            'pph21_terutang' => 'required|numeric|min:0',

            // ✅ Hanya jika bulanan dan sama
            'bruto_perbulan' => [
                'nullable', 'numeric', 'min:1',
                Rule::requiredIf(fn() => $request->dibayar_bulanan == 1 && $request->bulanan_sama == 1),
            ],
            'banyak_bulan_bekerja' => [
                'nullable', 'integer', 'min:1', 'max:12',
                Rule::requiredIf(fn() => $request->dibayar_bulanan == 1 && $request->bulanan_sama == 1),
            ],
            'pph21_perbulan' => 'nullable|numeric|min:0',

            // ✅ Hanya jika bulanan dan tidak sama
            'bruto_jan' => 'nullable|numeric|min:0',
            'bruto_feb' => 'nullable|numeric|min:0',
            'bruto_mar' => 'nullable|numeric|min:0',
            'bruto_apr' => 'nullable|numeric|min:0',
            'bruto_mei' => 'nullable|numeric|min:0',
            'bruto_jun' => 'nullable|numeric|min:0',
            'bruto_jul' => 'nullable|numeric|min:0',
            'bruto_agt' => 'nullable|numeric|min:0',
            'bruto_sept' => 'nullable|numeric|min:0',
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
            'pajak_agt' => 'nullable|numeric|min:0',
            'pajak_sept' => 'nullable|numeric|min:0',
            'pajak_okt' => 'nullable|numeric|min:0',
            'pajak_nov' => 'nullable|numeric|min:0',
            'pajak_des' => 'nullable|numeric|min:0',

            // ✅ Jika tidak dibayar bulanan
            'total_bruto' => [
                'nullable', 'numeric', 'min:1',
                Rule::requiredIf(fn() => $request->dibayar_bulanan == 0),
            ],
            'pihak_ketiga' => 'nullable|boolean',
            'biaya_pihak_ketiga' => [
                'nullable', // Mengizinkan nilai null jika tidak diisi
                'numeric',  // Memastikan tipe data adalah angka
                // Gunakan Rule::when untuk menerapkan 'min:1' hanya jika pihak_ketiga adalah 1 DAN biaya_pihak_ketiga tidak null
                Rule::when($request->pihak_ketiga == 1, ['required', 'min:1']),
            ],
            'penghasilan_neto' => 'nullable|numeric|min:0',
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

        $bukan = BukanPegawai::create([
            'pengguna_id' => $user->id,
            'role' => 'Bukan Pegawai',
            'dibayar_bulanan' => $request->dibayar_bulanan,
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
            'pihak_ketiga' => $request->pihak_ketiga,
            'biaya_pihak_ketiga' => $request->biaya_pihak_ketiga,
            'metode_penghitungan' => $request->metode_penghitungan,
            'pph21_terutang' => $request->pph21_terutang,
            'tarif' => $request->tarif,
            'pph21_perbulan' => $request->pph21_perbulan,
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
            'penghasilan_neto' => $request->penghasilan_neto,
        ]);

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


    /**
     * Display the specified resource.
     */
    public function show(BukanPegawai $bukanPegawai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BukanPegawai $bukanPegawai)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBukanPegawaiRequest $request, BukanPegawai $bukanPegawai)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BukanPegawai $bukanPegawai)
    {
        //
    }
}
