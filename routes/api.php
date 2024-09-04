<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KlaimController;

Route::get('/klaim', [KlaimController::class, 'index']);
// Route::post('/klaim', [KlaimController::class, 'store']);
// Route::get('/klaim/{id}', [KlaimController::class, 'show']);
// Route::put('/klaim/{id}', [KlaimController::class, 'update']);
// Route::delete('/klaim/{id}', [KlaimController::class, 'destroy']);
// Route::post('/send-claim', [KlaimController::class, 'sendClaim']);