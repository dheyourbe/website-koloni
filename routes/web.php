<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes - hanya untuk user dengan is_admin = true
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin routes akan dihandle oleh Filament
    // Middleware 'admin' akan memastikan hanya admin yang bisa akses /admin/*
});

require __DIR__.'/auth.php';
