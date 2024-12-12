<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CustomLogsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Models\Announcement;
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
    $announcements = Announcement::latest('updated_at')->get();

    return view('welcome', compact('announcements'));
});

Auth::routes();

Route::get('home', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('users/anydata', [UserController::class, 'anydata'])->name('users.anydata');
    Route::get('users/{id}/status', [UserController::class, 'getStatusHistories'])->name('users.getStatusHistories');
    Route::post('users/{id}/status', [UserController::class, 'storeStatusHistories'])->name('users.storeStatusHistories');
    Route::patch('users/{id}/verifikasiPembuatanAkun', [UserController::class, 'verifikasiPembuatanAkun'])->name('users.verifikasiPembuatanAkun');
    Route::patch('users/{id}/izinkanAksesDashboard', [UserController::class, 'izinkanAksesDashboard'])->name('users.izinkanAksesDashboard');
    Route::resource('users', UserController::class)->except(['create', 'store', 'show', 'edit', 'destroy']);

    Route::get('announcements/anydata', [AnnouncementController::class, 'anydata'])->name('announcements.anydata');
    Route::resource('announcements', AnnouncementController::class);

    // * Logs Route
    Route::get('logs', [CustomLogsController::class, 'index']);
});

Route::fallback(function () {
    return redirect()->route('home')->with('error', 'Halaman Tidak Ditemukan');
});
