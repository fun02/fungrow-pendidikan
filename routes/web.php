<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AiController;

// Halaman Utama
Route::get('/', function () {
    return view('pendidikan');
});

// Jalur AI (Pastikan kedua jalur ini ada!)
Route::post('/ai/summarize', [AiController::class, 'summarize']);
Route::post('/ai/ask', [AiController::class, 'ask']);
Route::post('/auth/send-otp', [AiController::class, 'sendOtpEmail']);

