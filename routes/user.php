<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserUptController;
use App\Http\Controllers\User\UserPpjkController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\UserMitraController;
use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\UserCabangController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\User\UpdatePenggunaJasaController;

Route::prefix('barantin')->name('barantin.')->group(function () {
    Route::prefix('login')->name('auth.')->group(function () {
        Route::get('', [LoginController::class, 'index'])->name('index');
        Route::post('store', [LoginController::class, 'login'])->name('login');
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    });

    Route::prefix('update-pjk')->name('pjk.')->group(function () {
        Route::get('message', [UpdatePenggunaJasaController::class, 'Message'])->name('message');
        Route::middleware('check.update.token')->group(function () {
            Route::get('{barantin_id}/{token}', [UpdatePenggunaJasaController::class, 'UpdateIndex'])->name('update');
            Route::get('form/{barantin_id}/{token}', [UpdatePenggunaJasaController::class, 'UpdateForm'])->name('form');
        });
        Route::prefix('pendukung')->name('pendukung.')->group(function () {
            Route::get('datatable/{id}', [UpdatePenggunaJasaController::class, 'DokumenPendukungDataTable'])->name('datatable');
            Route::post('store/{id}', [UpdatePenggunaJasaController::class, 'DokumenPendukungStore'])->name('store');
            Route::delete('destroy/{id}', [UpdatePenggunaJasaController::class, 'DokumenPendukungDestroy'])->name('destroy');
        });
        Route::prefix('store')->name('store.')->group(function () {
            Route::patch('perorangan/{id}', [UpdatePenggunaJasaController::class, 'StoreRegisterPerorangan'])->name('perorangan');
            Route::patch('perusahaan/{id}', [UpdatePenggunaJasaController::class, 'StoreRegisterPerusahaan'])->name('perusahaan');
        });


    });
    Route::middleware('auth')->group(function () {
        Route::prefix('dashboard')->name('dashboard.')->group(function () {
            Route::get('', [DashboardController::class, 'index'])->name('index');
        });

        Route::prefix('cabang')->name('cabang.')->middleware('induk')->group(function () {
            Route::post('cancel', [UserCabangController::class, 'cancel'])->name('cancel');
            Route::get('upt/detail/{id}', [UserCabangController::class, 'DatatableUptDetail'])->name('upt.detail');

            Route::post('confirmasi/{cabang_id}', [UserCabangController::class, 'confirmasi'])->name('confirmasi');

            Route::prefix('pendukung')->name('pendukung.')->group(function () {
                Route::get('datatable/{id}', [UserCabangController::class, 'DokumenPendukungDataTable'])->name('datatable');
                Route::post('store/{id}', [UserCabangController::class, 'DokumenPendukungStore'])->name('store');
                Route::delete('destroy/{id}', [UserCabangController::class, 'DokumenPendukungDestroy'])->name('destroy');
            });
        });

        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('', [UserProfileController::class, 'index'])->name('index');
            Route::get('form-keterangan-update', [UserProfileController::class, 'FormKeteranganUpdate'])->name('form-keterangan-update');
            Route::post('update', [UserProfileController::class, 'RequestUpdate'])->name('update');
        });

        Route::resource('cabang', UserCabangController::class)->except(['edit', 'update', 'destroy'])->middleware('induk');
        Route::resource('ppjk', UserPpjkController::class);
        Route::resource('mitra', UserMitraController::class);
        Route::resource('upt', UserUptController::class)->only(['create', 'index', 'store']);
    });

});
