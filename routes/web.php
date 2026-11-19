<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return redirect()->route('rooms.index');
});

Route::get('/kamar', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/kamar/{id}', [RoomController::class, 'show'])->name('rooms.show');

Route::get('/sewa/{roomId}', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/sewa', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/pengajuan/{id}', [BookingController::class, 'confirmation'])->name('bookings.confirmation');