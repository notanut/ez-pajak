<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenggunaController;


Route::get('/', function () {
    return view('homePage');
});


Route::get('/calculator/pegawai', function () {
    return view('calculator.index');
});


Route::get('/calculator/pegawaiTidakTetap', function () {
    return view('calculator.pegawaiTidakTetap');
});


Route::get('/calculator/bukanPegawai', function () {
    return view('calculator.bukanPegawai');
});


Route::get('/payment/success', function () {
    return view('payment.success');
});


Route::get('/dashboard', function (){
    return view('calculator.index');
});


Route::get('/home', function (){
    return view('home.index');
});


Route::get('/payment/paypage', function () {
    return view('payment.paypage');
});


// Route::post('/payment/paypage/{id}',[PenggunaController::class,'index']);
Route::get('/payment/paypage/{id}',[PenggunaController::class,'show']);

Route::get('/kuesioner', function () {
    return view('kuesioner');
});
