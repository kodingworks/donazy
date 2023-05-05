<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/artisan', [\App\Http\Controllers\Api\ArtisanController::class, 'store']);
Route::get('/campaigns', [\App\Http\Controllers\Api\CampaignController::class, 'index'])->middleware(\App\Http\Middleware\IsAjax::class);
