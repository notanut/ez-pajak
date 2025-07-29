<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Http\Requests\StoreTransaksiRequest;
use App\Http\Requests\UpdateTransaksiRequest;
use Illuminate\Http\Request;

class TransaksiController extends Controller
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
    public function store(StoreTransaksiRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransaksiRequest $request, Transaksi $transaksi)
    {
        //
    }

    public function bayar(Request $request)
    {
        if (!auth()->check()) {
            abort(403, 'User tidak login');
        }

        $request->validate([
            'transaksi_id' => 'required|exists:transaksis,id',
            'metode_pembayaran' => 'required|string',
        ]);

        $transaksi = Transaksi::findOrFail($request->transaksi_id);
        if ($transaksi->pengguna_id !== auth()->id()) {
            abort(403, 'Kamu tidak punya izin untuk transaksi ini');
        }

        $transaksi->status_pembayaran = '1';
        $transaksi->metode_pembayaran = $request->metode_pembayaran;
        $transaksi->save();

        return redirect('/payment/success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        //
    }
}
