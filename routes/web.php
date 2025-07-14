<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenggunaController;

use App\Http\Controllers\PegawaiTetapController;
use App\Http\Controllers\BukanPegawaiController;
use App\Http\Controllers\PegawaiTidakTetapController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;

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

Route::post('/pegawai-tetap/store', [PegawaiTetapController::class, 'store'])
    ->name('pegawai-tetap.store')
    ->middleware('auth');


Route::get('/calculator/pegawaiTidakTetap', function () {
    return view('calculator.pegawaiTidakTetap');
});


Route::get('/calculator/bukanPegawai', function () {
    return view('calculator.bukanPegawai');
});

Route::middleware('auth')->post('/bukan-pegawai/store', [BukanPegawaiController::class, 'store'])->name('bukan-pegawai.store');


Route::get('/payment/success', function () {
    return view('payment.success');
});


// Route::get('/dashboard', function (){
//     return view('calculator.index');
// });


// Route::get('/home', function (){
//     return view('home.index');
// });

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

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

// Route::get('/register', function (){
//     return view('registration.register');
// });

// Route::get('/login', function (){
//     return view('registration.login');
// });

// Route::get('/login', function () {
//     return view('registration.login');
// })->name('login');

Route::get('/login', function () {
    return view('registration.login');
})->middleware('guest')->name('login');


Route::post('/login',[LoginController::class,'login'])->name('pengguna.login');

Route::get('/exit', [LoginController::class, 'exit'])->name('pengguna.logout');

Route::post('/import-guest-pajak', [PajakController::class, 'importGuest'])->middleware('auth');
