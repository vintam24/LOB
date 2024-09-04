<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KlaimController;

Route::post('/unit-testing', [KlaimController::class, 'unitTesting']);