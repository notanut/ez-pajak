<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Transaksi;
use App\Http\Requests\StorePenggunaRequest;
use App\Http\Requests\UpdatePenggunaRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Notifications\NotifikasiEmail;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $penggunas = Pengguna::find(5);

        $messages['hi'] = "Hey, {$penggunas->name}";
        $messages['isi'] = "Ayo Bayar Pajak lewat EzPajak";

        $penggunas->notify(new NotifikasiEmail($messages));

        dd('Done');

    }

    public function indexJadwal(Request $request, Pengguna $pengguna)
    {

        $messages["hi"] = "Hey, {$pengguna->name}";
        $messages["isi"] = "Ini adalah pengingat terjadwal Anda!";

        // Waktu kirimnya kapan
        $waktuKirim = now()->addDays(5);

        KirimNotifikasiTerjadwal::dispatch($pengguna, $messages)
                                ->delay($waktuKirim);

        return "Notifikasi untuk {$pengguna->name} telah dijadwalkan untuk dikirim pada: " . $waktuKirim->format('Y-m-d H:i:s');
    }

    public function show($id)
    {
        //
        $penggunas = Pengguna::with('transaksis')->find($id);
        $transaksi = $penggunas->transaksis->first();
        // $penggunaa = Pengguna::with('transaksis.transaksiable')->find($id);

        if($transaksi->status_pembayaran == true){
            $status = 'Sudah dibayar';
        }else{
            $status = 'Belum dibayar';
        }

        // $detail = $penggunaa->transaksis;
        // $details = $detail->transaksiable;
        // $info = $transaksi->transaksiable_type;
        return view('payment.paypage',compact('penggunas','transaksi','status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('registration.register');

    }

    public function prosesForm(Request $request){
        dump($request);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePenggunaRequest $request)
    {
        $validated = $request->validated();

        Pengguna::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);




        return redirect()->route('pengguna.create')->with('success', 'Registrasi berhasil!');
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
