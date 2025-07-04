<?php

namespace App\Http\Controllers;

use App\Models\PegawaiTetap;
use App\Http\Requests\StorePegawaiTetapRequest;
use App\Http\Requests\UpdatePegawaiTetapRequest;
use Illuminate\Http\Request;
use App\Models\Transaksi;

class PegawaiTetapController extends Controller
{
    public function store(Request $request)
    {
        // Simpan pegawai tetap
        // $pegawai = PegawaiTetap::create([
        //     'role' => 'pegawai_tetap',
        //     'jenis_kelamin' => $request->jenis_kelamin,
        //     'tanggungan' => $request->tanggungan,
        //     'status_perkawinan' => $request->status_perkawinan,
        //     'bruto_perbulan' => $request->bruto_perbulan ?? 0,
        //     'banyak_bulan_bekerja' => $request->banyak_bulan_bekerja ?? 0,
        //     'total_bruto' => $request->total_bruto,
        //     'lama_hari_bekerja' => $request->lama_hari_bekerja ?? 0,
        //     'avg_bruto' => $request->avg_bruto ?? 0,
        //     'metode_penghitungan' => $request->metode_penghitungan,
        //     'pph21_terutang' => $request->pph21_terutang,
        //     'pph21_perbulan' => $request->pph21_perbulan ?? 0,
        //     'pph21_perhari' => $request->pph21_perhari ?? 0,
        // ]);

        // // Simpan transaksi (tanpa user login)
        // Transaksi::create([
        //     'total' => $request->pph21_terutang,
        //     'status_pembayaran' => false,
        //     'metode_pembayaran' => '-',
        //     'tanggal_pembayaran' => now(),
        //     'pengguna_id' => null, // nanti auth()->id() jika sudah login
        // ]);

        // return response()->json(['message' => 'Data berhasil disimpan']);
    }
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
    // public function store(StorePegawaiTetapRequest $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(PegawaiTetap $pegawaiTetap)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PegawaiTetap $pegawaiTetap)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePegawaiTetapRequest $request, PegawaiTetap $pegawaiTetap)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PegawaiTetap $pegawaiTetap)
    {
        //
    }
}
