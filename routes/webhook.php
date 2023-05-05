<?php

use Illuminate\Support\Facades\Route;

Route::post('/webhook/mutasibank', [\App\Http\Controllers\Webhook\MutasiBankController::class, 'store']);
Route::post('/webhook/moota', [\App\Http\Controllers\Webhook\MootaController::class, 'store']);
