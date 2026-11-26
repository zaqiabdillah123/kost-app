<?php

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('rooms.index');
});

Route::get('/kamar', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/kamar/{id}', [RoomController::class, 'show'])->name('rooms.show');

Route::get('/sewa/{roomId}', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/sewa', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/pengajuan/{id}', [BookingController::class, 'confirmation'])->name('bookings.confirmation');

Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store'])->name('login.store')->middleware('throttle:6,1');
Route::post('/logout', [SessionController::class, 'destroy'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('kamar', AdminRoomController::class)->names('admin.rooms')->parameters(['kamar' => 'room'])->except(['show']);
    Route::get('pengajuan', [AdminBookingController::class, 'index'])->name('admin.bookings.index');
    Route::get('pengajuan/{booking}/edit', [AdminBookingController::class, 'edit'])->name('admin.bookings.edit');
    Route::put('pengajuan/{booking}', [AdminBookingController::class, 'update'])->name('admin.bookings.update');
    Route::get('pengajuan/export', [AdminBookingController::class, 'export'])->name('admin.bookings.export');
});
