<?php

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BarantinController;
use App\Http\Controllers\Api\User\UptController;
use App\Http\Controllers\Api\User\PpjkController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\User\MitraController;
use App\Http\Controllers\Api\User\CabangController;
use App\Http\Controllers\Api\BarantinPpjkController;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Api\BarantinMitraController;
use App\Http\Controllers\Api\User\UserLoginController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * admin api routes
 * prefix v1 => api version
 */
Route::prefix('v1')->name('api.')->group(function () {
    Route::post('login', [LoginController::class, 'login'])->name('login');

    Route::get('failed', function () {
        return ApiResponse::errorResponse('Unauthorized', 401);
    })->name('failed');


    Route::middleware(['auth:api-v1', 'api.version:v1'])->group(function () {

        Route::get('refresh',[LoginController::class, 'refresh'])->name('refresh');
        Route::get('logout',[LoginController::class, 'logout'])->name('logout');

        Route::prefix('barantin')->name('barantin.')->group(function () {

            Route::get('{take}', [BarantinController::class, 'getAllDataBarantin'])->name('all');
            Route::get('{npwp}/cabang', [BarantinController::class, 'getAllDataBarantinPerusahaanCabang'])->name('cabang');
            Route::get('{barantin_id}/detil', [BarantinController::class, 'detilDataBarantinById'])->name('detil');
            Route::get('{register_id}/register', [BarantinController::class, 'getDataBarantinByRegisterID'])->name('register.detil');
        });
        Route::prefix('mitra')->name('mitra.')->group(function () {
            Route::get('{barantin_id}/barantin', [BarantinMitraController::class, 'GetAllDataMitraByBarantinID'])->name('all.barantin');
            Route::get('{mitra_id}', [BarantinMitraController::class, 'GetAllDataMitraByID'])->name('find.one');
        });
        Route::prefix('ppjk')->name('ppjk.')->group(function () {
            Route::get('cek-npwp', [BarantinPpjkController::class, 'cekNpwpPpjk'])->name('cek.npwp');
            // Route::get('{take}', [BarantinPpjkController::class, 'getPpjk'])->name('all.admin');
            Route::get('{barantin_id}', [BarantinPpjkController::class, 'getPpjkByBarantinId'])->name('barantin-id.admin');
            Route::get('{ppjk_id}/detil', [BarantinPpjkController::class, 'getDetailPpjk'])->name('one.admin');
        });
    });
});
/**
 * api user
 * prefix v2 => api version 2
 */
Route::prefix('v2')->name('api.')->group(function () {
    Route::prefix('user')->group(function () {

        Route::post('login', [UserLoginController::class, 'loginUser'])->name('login');

        Route::middleware(['auth:api-v2', 'api.version:v2'])->group(function () {

            Route::get('refresh',[UserLoginController::class, 'refresh'])->name('refresh');
            Route::get('logout',[UserLoginController::class, 'logout'])->name('logout');

            Route::get('upt', [UptController::class, 'getAllUptUser'])->name('upt');
            Route::get('profile', [ProfileController::class, 'getProfileUser'])->name('profile');

            Route::prefix('mitra')->name('mitra.')->group(function () {
                Route::get('', [MitraController::class, 'getAllMitraUser'])->name('all');
                Route::post('store', [MitraController::class, 'createMitra'])->name('store');
                Route::get('{mitra_id}', [MitraController::class, 'getMitraByID'])->name('one');
            });

            Route::prefix('cabang')->name('cabang.')->group(function () {
                Route::get('', [CabangController::class, 'getCabangPerusahaanInduk'])->name('all.user');
                Route::get('{barantin_id}', [CabangController::class, 'getDetailCabangPerusahaanInduk'])->name('one.user');
            });

            Route::prefix('ppjk')->name('ppjk.')->group(function () {
                Route::get('', [PpjkController::class, 'getPpjk'])->name('all.user');
                Route::get('{ppjk_id}', [PpjkController::class, 'getDetailPpjk'])->name('one.user');
            });
        });
    });
});
