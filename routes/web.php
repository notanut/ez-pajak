<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PegawaiTetapController;
use App\Http\Controllers\BukanPegawaiController;
use App\Http\Controllers\PegawaiTidakTetapController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Auth;

Route::get('/cek-user', function () {
    dd(Auth::user());
});

Route::get('/', function () {
    return view('homePage');
})->name('exit');


Route::get('/calculator/pegawai', function () {
    return view('calculator.index');
});

Route::post('/pegawai-tetap/store', [PegawaiTetapController::class, 'store'])->name('pegawai-tetap.store')->middleware('auth');
// Route::get('/pegawai-tetap/store', [PegawaiTetapController::class, 'create'])->name('pegawai-tetap.create')->middleware('auth');

Route::get('/pegawai-tetap/create', [PegawaiTetapController::class, 'create'])->name('pegawai-tetap.create')->middleware('auth');
// Rute untuk mengedit Pegawai Tetap
Route::get('/pegawai-tetap/{transaksi}/edit', [PegawaiTetapController::class, 'edit'])->name('pegawai-tetap.edit')->middleware('auth');
// Rute untuk update Pegawai Tetap
Route::put('/pegawai-tetap/{transaksi}', [PegawaiTetapController::class, 'update'])->name('pegawai-tetap.update')->middleware('auth');


Route::get('/calculator/pegawaiTidakTetap', function () {
    return view('calculator.pegawaiTidakTetap');
});


Route::get('/calculator/bukanPegawai', function () {
    return view('calculator.bukanPegawai');
});

Route::middleware('auth')->post('/bukan-pegawai/store', [BukanPegawaiController::class, 'store'])->name('bukan-pegawai.store');
// Rute untuk mengedit Bukan Pegawai
Route::get('/bukan-pegawai/{transaksi}/edit', [BukanPegawaiController::class, 'edit'])->name('bukan-pegawai.edit')->middleware('auth');
// Rute untuk update Bukan Pegawai (akan dibuat di langkah selanjutnya)
Route::put('/bukan-pegawai/{transaksi}', [BukanPegawaiController::class, 'update'])->name('bukan-pegawai.update')->middleware('auth');

Route::middleware('auth')->post('/pegawai-tidak-tetap/store', [PegawaiTidakTetapController::class, 'store'])->name('pegawai-tidak-tetap.store');
// Rute untuk mengedit Pegawai Tidak Tetap
Route::get('/pegawai-tidak-tetap/{transaksi}/edit', [PegawaiTidakTetapController::class, 'edit'])->name('pegawai-tidak-tetap.edit')->middleware('auth');
// Rute untuk update Pegawai Tidak Tetap (akan dibuat di langkah selanjutnya)
Route::put('/pegawai-tidak-tetap/{transaksi}', [PegawaiTidakTetapController::class, 'update'])->name('pegawai-tidak-tetap.update')->middleware('auth');


Route::get('/payment/success', function () {
    return view('payment.success');
});

Route::post('/transaksi/bayar', [TransaksiController::class, 'bayar'])->middleware('auth')->name('transaksi.bayar');


// Route::get('/dashboard', function (){
//     return view('calculator.index');
// });


// Route::get('/home', function (){
//     return view('home.index');
// });

// Route::get('/jadwalkan-notifikasi/{pengguna}', [HomeController::class, 'index'])->name('home')->middleware('auth');
// Coba diganti menjadi
// Route::get('/jadwalkan-notifikasi/{pengguna}', [PenggunaController::class, 'showJadwalForm'])->name('jadwal.notifikasi.form')->middleware('auth'); // Contoh: Tambahkan metode baru di PenggunaController
Route::post('/jadwalkan-notifikasi/{pengguna}', [PenggunaController::class, 'indexJadwal'])->name('jadwal.notifikasi');

Route::get('/payment/paypage', function () {
    return view('payment.paypage');
});
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth', 'verified');

Route::middleware('auth')->post('/payment/paypage/{id}',[PenggunaController::class,'index']);
// Route::get('/payment/paypage/{id}',[PenggunaController::class,'show']);
Route::get('/payment/paypage/{transaksi}', [PenggunaController::class, 'show'])->name('payment.show');
Route::get('/kuesioner', function () {
    return view('kuesioner');
});

// Route::post('/register', [PenggunaController::class, 'store'])->name('pengguna.store');
// Route::get('/register', [PenggunaController::class, 'create'])->name('pengguna.create');
// Route::post('/proses-form', [PenggunaController::class, 'prosesForm']);

// Route::get('/login', function (){
//     return view('registration.login');
// })->middleware('guest')->name('login');


// Route::post('/login',[LoginController::class,'login'])->name('pengguna.login');

// Route::get('/exit', [LoginController::class, 'exit'])->name('pengguna.logout');

Route::get('/history/{id}', [HistoryController::class, 'index'])->name('history');

Route::get('/download/{id}', [HistoryController::class, 'download'])->name('download');



// Daerah Buat Tes Notif
Route::get('user-notify', [PenggunaController::class, 'index']);
Route::get('/test-notifikasi-cepat', [PenggunaController::class, 'testNotifikasi']);



// use Illuminate\Support\Facades\Mail;

// Route::get('/tes-email', function () {
//     try {
//         Mail::raw('Ini adalah isi email percobaan.', function ($message) {
//             $message->to('test@example.com') // Ganti dengan email tujuan di Mailtrap
//                     ->subject('Tes Koneksi Email Laravel');
//         });
//         return 'Email berhasil dikirim (secara teori). Cek Mailtrap!';
//     } catch (\Exception $e) {
//         return 'Gagal mengirim email. Error: ' . $e->getMessage();
//     }
// });

require __DIR__.'/auth.php';