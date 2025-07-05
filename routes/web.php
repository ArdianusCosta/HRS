<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/scan-absensi', [AbsensiController::class, 'store']);
