<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenggunaController;

use App\Http\Controllers\PegawaiTetapController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('homePage');
})->name('exit');


Route::get('/calculator/pegawai', function () {
    return view('calculator.index');
});

Route::post('/calculator/pegawai/store', [PegawaiTetapController::class, 'store'])->name('pegawai.store');

Route::get('/calculator/pegawaiTidakTetap', function () {
    return view('calculator.pegawaiTidakTetap');
});


Route::get('/calculator/bukanPegawai', function () {
    return view('calculator.bukanPegawai');
});


Route::get('/payment/success', function () {
    return view('payment.success');
});


// Route::get('/dashboard', function (){
//     return view('calculator.index');
// });


Route::get('/home', function (){
    return view('home.index');
});


Route::get('/payment/paypage', function () {
    return view('payment.paypage');
});


Route::post('/payment/paypage/{id}',[PenggunaController::class,'index']);
Route::get('/payment/paypage/{id}',[PenggunaController::class,'show']);

Route::get('/kuesioner', function () {
    return view('kuesioner');
});

Route::post('/register', [PenggunaController::class, 'store'])->name('pengguna.store');
Route::get('/register', [PenggunaController::class, 'create'])->name('pengguna.create');
Route::post('/proses-form', [PenggunaController::class, 'prosesForm']);

Route::get('/login', function (){
    return view('registration.login');
});


Route::post('/login',[LoginController::class,'login'])->name('pengguna.login');

Route::get('/exit', [LoginController::class, 'exit'])->name('pengguna.logout');

Route::get('/history', function (){
    return view('history');
});


Route::get('user-notify', [PenggunaController::class, 'index']);

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
