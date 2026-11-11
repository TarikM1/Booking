<?php

use Illuminate\Support\Facades\Route;
use App\Models\Service;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminSlotController;
use App\Http\Controllers\AdminBookingController;

Route::get('/', function () {
    $services = Service::where('is_active', true)
        ->orderBy('name')
        ->limit(3)
        ->get();

    return view('welcome', compact('services'));
})->name('home');

Route::get('/services', [ServiceController::class, 'index'])
    ->name('services.index');

Route::middleware(['auth', 'can:manage-services'])
    ->group(function () {

        Route::get('/services/create', [ServiceController::class, 'create'])
            ->name('services.create');

        Route::post('/services', [ServiceController::class, 'store'])
            ->name('services.store');

        Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])
            ->name('services.edit');

        Route::put('/services/{service}', [ServiceController::class, 'update'])
            ->name('services.update');

        Route::delete('/services/{service}', [ServiceController::class, 'destroy'])
            ->name('services.destroy');

        Route::get('/admin/slots', [AdminSlotController::class, 'index'])
            ->name('admin.slots.index');

        Route::post('/admin/slots', [AdminSlotController::class, 'store'])
            ->name('admin.slots.store');

        Route::patch('/admin/slots/{slot}/close', [AdminSlotController::class, 'close'])
            ->name('admin.slots.close');

        Route::get('/admin/bookings', [AdminBookingController::class, 'index'])
            ->name('admin.bookings.index');
    });

Route::get('/register', [AuthController::class, 'showRegister'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->middleware('guest')
    ->name('register.store');

Route::get('/login', [AuthController::class, 'showLogin'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware(['guest', 'throttle:6,1'])
    ->name('login.store');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/bookings/create', [BookingController::class, 'create'])
        ->name('bookings.create');

    Route::post('/bookings', [BookingController::class, 'store'])
        ->name('bookings.store');

    Route::get('/bookings', [BookingController::class, 'index'])
        ->name('bookings.index');

    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])
        ->name('bookings.cancel');
});
