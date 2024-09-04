<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KlaimController;

Route::get('/klaim', [KlaimController::class, 'index'])->name('klaim.index');
Route::post('/backup-data', [KlaimController::class, 'backupData'])->name('klaim.backup');
Route::get('/', function () {
    return view('welcome');
});
