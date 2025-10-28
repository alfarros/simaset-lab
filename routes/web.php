<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MaintenanceController; // Jangan lupa use-nya!
use App\Http\Controllers\PeminjamanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    // === Profile ===
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // === Asset: Akses Umum (semua user terautentikasi) ===
    Route::get('assets', [AssetController::class, 'index'])->name('assets.index');
    Route::get('assets/{asset}', [AssetController::class, 'show'])->name('assets.show');
    Route::patch('assets/{asset}/update-description', [AssetController::class, 'updateDescription'])->name('assets.updateDescription');
    Route::patch('assets/{asset}/update-status', [AssetController::class, 'updateStatus'])->name('assets.updateStatus');

    // === Maintenance: Akses Umum (staf bisa lapor) ===
    Route::get('/assets/{asset}/report-maintenance', [MaintenanceController::class, 'create'])->name('maintenance.create');
    Route::post('/assets/{asset}/maintenance', [MaintenanceController::class, 'store'])->name('maintenance.store');

    // === Kategori & Lokasi ===
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
    Route::get('/locations/{location}', [LocationController::class, 'show'])->name('locations.show');


    // === Hanya Admin ===
    Route::middleware('admin')->group(function () {
        // Asset CRUD
        Route::get('assets/create', [AssetController::class, 'create'])->name('assets.create');
        Route::post('assets', [AssetController::class, 'store'])->name('assets.store');
        Route::get('assets/{asset}/edit', [AssetController::class, 'edit'])->name('assets.edit');
        Route::put('assets/{asset}', [AssetController::class, 'update'])->name('assets.update');
        Route::delete('assets/{asset}', [AssetController::class, 'destroy'])->name('assets.destroy');

        // Maintenance: hanya admin yang bisa update/selesaikan
        Route::patch('/maintenance/{log}', [MaintenanceController::class, 'update'])->name('maintenance.update');
        Route::post('/maintenance/{log}/complete', [MaintenanceController::class, 'complete'])->name('maintenance.complete');
        Route::post('/maintenance/{log}/start', [MaintenanceController::class, 'start'])->name('maintenance.start');
    });
});

require __DIR__.'/auth.php';