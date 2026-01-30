<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;


// Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// Dashboard (Auth Protected)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Profile Routes (Auth Protected)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Products Routes (Auth Protected)
Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class);
});

// Categories Routes (Auth Protected)
Route::middleware('auth')->group(function () {
    Route::resource('categories', CategoryController::class);
    
});

// Suppliers Routes (Auth Protected)
Route::middleware('auth')->group(function () {
    Route::resource('suppliers', SupplierController::class);
});

require __DIR__.'/auth.php';

