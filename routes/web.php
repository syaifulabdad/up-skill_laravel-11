<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SuratMasukController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::auto('login', LoginController::class);
Route::auto('dashboard', DashboardController::class);
Route::auto('surat-masuk', SuratMasukController::class);