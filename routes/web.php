<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Middleware\CheckAdmin;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\ProductController;

Route::redirect('/', 'login');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', CheckAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('users', [AdminController::class, 'users'])->name('admin.users');
    Route::resource('products', AdminProductController::class);
    Route::get('products/api/create', [AdminProductController::class, 'createFromApi'])->name('products.api.create');
    Route::post('products/api/store/{product}', [AdminProductController::class, 'storeFromApi'])->name('products.api.store');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('products', ProductController::class);
});

require __DIR__.'/auth.php';
