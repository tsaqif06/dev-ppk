<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\SelectController;
use App\Http\Controllers\ExampleFetchDataFromAPi;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return redirect()->route('barantin.auth.index');
});




require_once __DIR__ . '/admin.php';
require_once __DIR__ . '/register.php';
require_once __DIR__ . '/user.php';


Route::prefix('select')->name('select.')->group(function () {
    Route::get('upt', [SelectController::class, 'SelectUpt'])->name('upt');
    Route::get('negara', [SelectController::class, 'SelectNegara'])->name('negara');
    Route::get('provinsi', [SelectController::class, 'SelectProvinsi'])->name('provinsi');
    Route::get('kota/{id}', [SelectController::class, 'SelectKota'])->name('provinsi');
    Route::get('perusahaan', [SelectController::class, 'SelectPerusahaanInduk'])->name('perusahaan');
});

Route::get('ajax/failed', function () {
    if (request()->ajax()) {
        return response()->json(['message' => 'Unauthorized', 'code' => 401, 'status' => "failed"], 401);
    }
    return redirect()->route('login');

})->middleware(['ajax', 'guest'])->name('ajax.failed');


// Route::prefix('user')->name('user.')->group(function () {
//     Route::view('mitra', 'user.mitra')->name('mitra');
//     Route::view('cabang', 'user.cabang')->name('cabang');
//     Route::view('ppjk', 'user.ppjk')->name('ppjk');
//     Route::view('profile', 'user.profile')->name('profile');
//     Route::view('upt', 'user.tambahupt')->name('upt');
//     // Route::view('rubah-data', 'user.rubahdata');
// });
Route::get('link', function () {
    Artisan::call('storage:link');
});
/* only test */


