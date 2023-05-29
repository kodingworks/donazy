<?php

use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

Route::redirect('/admin', '/admin/home');

Route::group([
    'prefix' => 'admin',
    'as' => 'admin::',
], function () {
    Route::group([
        'prefix' => 'auth',
        'as' => 'auth.',
    ], function () {
        Route::get('/login', [Admin\Auth\LoginController::class, 'index'])
            ->name('login')
            ->middleware(['guest']);
        Route::post('/login', [Admin\Auth\LoginController::class, 'store'])
            ->middleware(['guest']);
        Route::post('/logout', [Admin\Auth\LoginController::class, 'destroy'])
            ->name('logout')
            ->middleware(['auth', 'is_admin']);
    });

    Route::middleware(['auth', 'is_admin'])
        ->group(function () {
            Route::view('/home', 'admin::home')->name('home');
            Route::group([
                'prefix' => 'transactions',
                'as' => 'transactions.'
            ], function () {
                Route::get('/', [Admin\TransactionController::class, 'index'])->name('index');
                Route::get('/{transaction}', [Admin\TransactionController::class, 'show'])->name('show');
                Route::put('/{transaction}/status', [Admin\TransactionStatusController::class, 'update'])->name('statuses.update');
            });
            Route::get('/mutations', [Admin\MutationController::class, 'index'])->name('mutations.index');
            Route::group([
               'prefix' => 'profile',
               'as' => 'profile.',
            ], function () {
                Route::get('/', [Admin\ProfileController::class, 'edit'])->name('edit');
                Route::put('/', [Admin\ProfileController::class, 'update'])->name('update');
            });
            Route::resource('users', Admin\UserController::class);
            Route::resource('campaigns', Admin\CampaignController::class);
            Route::resource('paymentMethod', Admin\PaymentMethodController::class);
            Route::resource('sliders', Admin\SliderController::class);
            Route::resource('banners', Admin\BannerController::class);
        });

    Route::view('/example', 'admin::examples.components');
});
