<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/calculator', function () {
    return view('calculator.index');
});
Route::get('/payment/success', function () {
    return view('payment.sucess');
});
