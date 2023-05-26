<?php

use App\Http\Controllers\PaymentMethodController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group([
    'prefix' => 'campaigns',
    'as' => 'campaigns.',
], function () {
    Route::get('/', [\App\Http\Controllers\CampaignController::class, 'index'])->name('index');
    Route::get('/{slug}', [\App\Http\Controllers\CampaignController::class, 'show'])->name('show');
    Route::get('/{slug}/transactions/create', [\App\Http\Controllers\CampaignTransactionController::class, 'create'])->name('transactions.create');
    Route::post('/{slug}/transaction', [\App\Http\Controllers\CampaignTransactionController::class, 'store'])->name('transactions.store');
});

Route::get('/transactions/{code}', [\App\Http\Controllers\TransactionController::class, 'show'])->name('transactions.show');

Route::controller(PaymentMethodController::class)->group(function () {
    Route::get('/payment-methods', 'getPaymentMethod')->name('payment-methods.index');
});

Route::middleware(['auth'])
    ->group(function () {
        Route::group([
            'prefix' => 'profile',
            'as' => 'profile.',
        ], function () {
            Route::get('/', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('edit');
            Route::put('/', [\App\Http\Controllers\ProfileController::class, 'update'])->name('update');
        });
        Route::group([
            'prefix' => 'my-transactions',
            'as' => 'my-transactions.',
        ], function () {
            Route::get('/', [\App\Http\Controllers\MyTransactionController::class, 'index'])->name('index');
        });
    });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

require __DIR__ . '/auth.php';

require __DIR__ . '/admin.php';
