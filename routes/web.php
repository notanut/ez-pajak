<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('homePage');
});
Route::get('/calculator', function () {
    return view('calculator.index');
});
Route::get('/payment/success', function () {
    return view('payment.success');
});

Route::get('/kuesioner', function () {
    return view('kuesioner');
});
