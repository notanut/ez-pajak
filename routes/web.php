<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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
