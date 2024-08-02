<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MasterUptController;
use App\Http\Controllers\Admin\PendaftarController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\PermohonanController;
use App\Http\Controllers\Admin\PermohonanUpdateDataController;


Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('admin', function () {
        return redirect()->route('admin.auth.index');
    });

    Route::prefix('login')->name('auth.')->group(function () {
        Route::get('', [LoginController::class, 'index'])->name('index');
        Route::post('auth', [LoginController::class, 'login'])->name('login');
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    });

    Route::middleware(['auth:admin', 'refresh.token'])->group(function () {
        Route::prefix('dashboard')->name('dashboard.')->group(function () {
            Route::get('', [DashboardController::class, 'index'])->name('index');
        });

        Route::prefix('permohonan')->name('permohonan.')->group(function () {

            Route::prefix('datatable')->name('datatable.')->group(function () {
                Route::get('/dokumen/{id}', [PermohonanController::class, 'datatablePendukung'])->name('pendukung');
            });
            Route::post('/confirm/register/{id}', [PermohonanController::class, 'confirmRegister'])->name('confirm.register');
            Route::get('/print/{id}', [PermohonanController::class, 'print'])->name('print');
        });
        Route::prefix('pendaftar')->name('pendaftar.')->group(function () {
            Route::prefix('datatable')->name('datatable.')->group(function () {
                Route::get('/dokumen/{id}', [PendaftarController::class, 'datatablePendukung'])->name('pendukung');
            });

            Route::post('/block/akses/{id}', [PendaftarController::class, 'BlockAccessPendaftar'])->name('block.akses');
            Route::post('/open/akses/{id}', [PendaftarController::class, 'OpenkAccessPendaftar'])->name('open.akses');
            Route::post('/create/user/{id}', [PendaftarController::class, 'CreateUser'])->name('create.user');
            Route::post('/send/username/{id}', [PendaftarController::class, 'SendUsernamePasswordEmail'])->name('send.user');
        });
        Route::prefix('permohon-update')->name('permohonan-update.')->group(function () {
            Route::get('', [PermohonanUpdateDataController::class, 'index'])->name('index');
            Route::post('confirm/{pengajuan_id}', [PermohonanUpdateDataController::class, 'confirmUpdate'])->name('confirm');
            Route::get('{pengajuan_id}/show', [PermohonanUpdateDataController::class, 'show'])->name('show');
            Route::patch('{pengajuan_id}/update', [PermohonanUpdateDataController::class, 'updateData'])->name('update');
        });

        Route::resource('pendaftar', PendaftarController::class)->only(['index', 'show']);
        Route::resource('permohonan', PermohonanController::class)->only(['index', 'destroy', 'show']);
    });
});
