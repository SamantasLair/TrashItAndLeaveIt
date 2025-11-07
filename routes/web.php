<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\BansusController;
use App\Http\Controllers\BookingController;

Route::get('/welcome', function(){
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });
    
    Route::get('/login',  [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->group(function () {
    Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->name('mahasiswa.dashboard');
    Route::get('/booking/create', [BookingController::class, 'create'])->name('mahasiswa.booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('mahasiswa.booking.store');
    Route::get('/booking/{booking}', [BookingController::class, 'show'])->name('mahasiswa.booking.show');
    Route::delete('/booking/{booking}', [BookingController::class, 'destroy'])->name('mahasiswa.booking.destroy');
    Route::get('/booking/check-availability', [BookingController::class, 'checkAvailability'])->name('mahasiswa.booking.check');
});

Route::middleware(['auth', 'role:bansus'])->prefix('bansus')->group(function () {
    Route::get('/dashboard', [BansusController::class, 'dashboard'])->name('bansus.dashboard');
    Route::get('/bookings', [BansusController::class, 'index'])->name('bansus.bookings.index');
    Route::get('/bookings/{booking}', [BansusController::class, 'show'])->name('bansus.bookings.show');
    Route::patch('/bookings/{booking}/approve', [BansusController::class, 'approve'])->name('bansus.bookings.approve');
    Route::patch('/bookings/{booking}/reject', [BansusController::class, 'reject'])->name('bansus.bookings.reject');
    Route::delete('/bookings/{booking}', [BansusController::class, 'destroy'])->name('bansus.bookings.destroy');
    
    Route::resource('labs', \App\Http\Controllers\LabController::class)->names('admin.labs');
});