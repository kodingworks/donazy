<?php

use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Api\ArtisanController;
use App\Http\Controllers\Api\CampaignController as ApiCampaignController;
use App\Http\Controllers\Api\TransactionController as ApiTransactionController;
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

Route::post('/artisan', [ArtisanController::class, 'store']);
Route::get('/campaigns', [ApiCampaignController::class, 'index'])->middleware(\App\Http\Middleware\IsAjax::class);
Route::prefix('v1')->group(function () {
    Route::controller(ApiCampaignController::class)->prefix('campaigns')->group(function() {
        Route::get('/', 'getList');
        Route::get('/{slug}', 'getDetail');
        Route::get('/{slug}/donors', 'getDonors');
    });

    Route::controller(ApiTransactionController::class)->prefix('transaction')->group(function() {
        Route::post('/{slug}/create-transaction', 'createPayment');
        Route::post('/callback', 'callback');
        Route::get('/{invoice_id}/get-transaction', 'getTransaction');
    });
});