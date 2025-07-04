<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Transaksi;
use App\Http\Requests\StorePenggunaRequest;
use App\Http\Requests\UpdatePenggunaRequest;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function show($id)
    {
        //
        $penggunas = Pengguna::with('transaksis')->find($id);
        $transaksi = $penggunas->transaksis->first();
        $penggunaa = Pengguna::with('transaksis.transaksiable')->find($id);

        if($transaksi->status_pembayaran == '1'){
            $status = 'Sudah dibayar';
        }else{
            $status = 'Belum dibayar';
        }

        $detail = $penggunaa->transaksis;
        $details = $detail->transaksiable;
        $info = $transaksi->transaksiable_type;
        return view('payment.paypage',compact('penggunas','transaksi','status','info','penggunaa','detail','details'));
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
    public function store(StorePenggunaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengguna $pengguna)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePenggunaRequest $request, Pengguna $pengguna)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengguna $pengguna)
    {
        //
    }
}
