<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Transaksi;
use App\Http\Requests\StorePenggunaRequest;
use App\Http\Requests\UpdatePenggunaRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Notifications\NotifikasiEmail;
use App\Jobs\NotifikasiBayar;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\NotificationLog;

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
        // dd('Jalan Bangg');
        Log::info('Masuk indexJadwal', $request->all());

        $request->validate([
            'jumlah' => 'nullable|integer|min:1',
            'satuan' => 'nullable|string|in:Hari,Minggu',
            'waktu' => 'required|date_format:H.i',
            'email' => 'required|email',
            'tanggal_manual' => 'nullable|date'
        ]);
        // dd($request->all());

        $jumlah = (int)$request->input('jumlah');
        $satuan = $request->input('satuan');
        $waktu = $request->input('waktu');
        $tanggalManual = $request->input('tanggal_manual');

        // dd($jumlah);
        // $waktuKirim = now()->addSeconds($jumlah);
        // Waktu kirimnya kapan

        $waktuKirim = Carbon::now(config('app.timezone'));

        $now = Carbon::now();

        if($tanggalManual){
            //Ini kalau ada tanggal manual
            $targetDate = Carbon::parse($tanggalManual)->setTimeFromTimeString($waktu);
            $waktuKirim = $targetDate;
        }else{
            //Ini kalau gaada tanggal manual
            $tanggalTarget = Carbon::create($now->year, 3, 31);

            if ($now->greaterThan($tanggalTarget)) {
                $tanggalTarget = Carbon::create($now->year + 1, 3, 31);
            }

            if($satuan === 'Hari'){
                $waktuKirim = $tanggalTarget->subDays($jumlah);
            }elseif ($satuan === 'Minggu'){
                $waktuKirim = $tanggalTarget->subWeeks($jumlah);
            }
        }


        $pesan["hi"] = "Hey, {$pengguna->nama}";
        $pesan["isi"] = "Ini adalah pengingat terjadwal Anda!";

        NotifikasiBayar::dispatch($pengguna, $pesan)->delay($waktuKirim);

        NotificationLog::create([
            'pengguna_id' => $pengguna->id,
            'notification_type' => 'NotifikasiBayar',
            'email' => $request->input('email'),
            'scheduled_at' => $waktuKirim,
        ]);

        Log::info('Notifikasi dijadwalkan', [
            'pengguna_id' => $pengguna->id,
            'email' => $request->input('email'),
            'waktu_kirim' => $waktuKirim->toDateTimeString(),
        ]);

        if(!$tanggalManual){
            return redirect('/home');
        }

        return response()->json([
            'message' => 'Notifikasi berhasil dijadwalkan',
        ]);

        // return back()->with('status', 'Notifikasi berhasil dijadwalkan untuk dikirim pada ' . $waktuKirim->format('d F Y H:i'));
    }

    public function testNotifikasi()
    {
        // 1. Ambil pengguna pertama sebagai sampel untuk tes.
        // Pastikan Anda memiliki setidaknya satu data pengguna di database.
        $pengguna = Pengguna::first();

        if (!$pengguna) {
            return "Gagal: Tidak ada data pengguna untuk dites. Silakan buat satu pengguna terlebih dahulu.";
        }

        // 2. Buat pesan tes
        $pesan = [
            'hi'  => "Hai (Tes Cepat), {$pengguna->name}!",
            'isi' => "Ini adalah email tes yang dijadwalkan untuk dikirim dalam 5 detik."
        ];

        // 3. Set waktu tunda 5 detik dari sekarang
        $waktuKirim = now()->addSeconds(5);

        // 4. Dispatch job dengan delay singkat
        NotifikasiBayar::dispatch($pengguna, $pesan)->delay($waktuKirim);

        // 5. Berikan respons konfirmasi ke browser
        return "Notifikasi tes untuk <strong>{$pengguna->email}</strong> telah dijadwalkan. <br>Harap periksa terminal queue worker dan inbox email Anda dalam 5 detik.";
    }
    // ==================================================================

    // Method `show` akan menerima objek Transaksi langsung berkat Route Model Binding
    public function show(Transaksi $transaksi)
    {
        // Otorisasi: Pastikan transaksi ini milik pengguna yang sedang login
        if ($transaksi->pengguna_id !== Auth::id()) {
            abort(403, 'Akses Ditolak');
        }

        $totalAsli = $transaksi->total;
        $denda = 0;
        $status = $transaksi->status_pembayaran ? 'Sudah Lunas' : 'Belum Lunas';

        $biayaAdmin = $totalAsli / 100;
        // --- LOGIKA PERHITUNGAN DENDA ---

        // Tentukan tanggal jatuh tempo (31 Maret tahun berikutnya)
        $tahunPajak = $transaksi->created_at->year;
        $jatuhTempo = Carbon::create($tahunPajak + 1, 3, 31)->endOfDay();

        // Cek apakah belum lunas DAN sudah lewat jatuh tempo
        if (!$transaksi->status_pembayaran && Carbon::now()->greaterThan($jatuhTempo)) {
            // Hitung denda, contoh: 2% dari total pajak
            // Aturan denda resmi lebih kompleks, ini adalah contoh sederhana.
            $denda = $totalAsli * 0.02;
            $status = 'Terlambat';
        }

        $totalAkhir = $totalAsli + $denda + $biayaAdmin;

        $pengguna = Auth::user();

        return view('payment.paypage',compact('pengguna','transaksi','status', 'totalAsli', 'denda', 'biayaAdmin', 'totalAkhir'));
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
