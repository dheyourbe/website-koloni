<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Home route - accessible by everyone
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home.index');

// Profile route for authenticated users
Route::get('/my-profile', [HomeController::class, 'profile'])->middleware(['auth', 'verified'])->name('user.profile');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    // Admin routes akan dihandle oleh Filament
});

// Billiard Rental Routes
Route::prefix('billiard')->name('billiard.')->group(function () {
    Route::get('/', [App\Http\Controllers\BilliardController::class, 'index'])->name('index');
    Route::get('/book/{table?}', [App\Http\Controllers\BilliardController::class, 'book'])->name('book');
    Route::post('/store', [App\Http\Controllers\BilliardController::class, 'store'])->name('store');
    Route::get('/success/{rental}', [App\Http\Controllers\BilliardController::class, 'success'])->name('success');
    Route::post('/calculate-price', [App\Http\Controllers\BilliardController::class, 'calculatePrice'])->name('calculate-price');
    Route::get('/receipt/{rental}/download', [App\Http\Controllers\BilliardController::class, 'downloadReceipt'])->name('receipt.download');

    // Member-only routes
    Route::middleware('auth')->group(function () {
        Route::get('/history', [App\Http\Controllers\BilliardController::class, 'history'])->name('history');
        Route::patch('/{rental}/payment-status', [App\Http\Controllers\BilliardController::class, 'updatePaymentStatus'])->name('update-payment-status');
    });
});

// Products Routes
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
});

require __DIR__.'/auth.php';
