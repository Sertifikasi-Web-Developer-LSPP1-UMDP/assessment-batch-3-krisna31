<?php

use App\Http\Controllers\CustomLogsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('home', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('users/anydata', [UserController::class, 'anydata'])->name('users.anydata');
    Route::get('users/{id}/status', [UserController::class, 'getStatusHistories'])->name('users.getStatusHistories');
    Route::post('users/{id}/status', [UserController::class, 'storeStatusHistories'])->name('users.getStatusHistories');
    Route::patch('users/{id}/verifikasiPembuatanAkun', [UserController::class, 'verifikasiPembuatanAkun'])->name('users.verifikasiPembuatanAkun');
    Route::resource('users', UserController::class);

    // * Logs Route
    Route::get('logs', [CustomLogsController::class, 'index']);

    Route::fallback(function () {
        return redirect()->route('home')->with('error', 'Page not found');
    });
});
