<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\InvestasiController;
use App\Http\Controllers\SedekahController;
use App\Http\Controllers\PwaController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// PWA routes
Route::prefix('pwa')->group(function () {
    Route::post('/install', [PwaController::class, 'install'])->name('pwa.install');
    Route::get('/check-update', [PwaController::class, 'checkUpdate'])->name('pwa.check-update');
    Route::post('/sync-offline', [PwaController::class, 'syncOfflineData'])->name('pwa.sync-offline');
    Route::get('/config', [PwaController::class, 'config'])->name('pwa.config');
});

// Protected routes
Route::middleware('auth.custom')->group(function () {
    Route::resource('transaksi', TransaksiController::class)->except(['show']);
    Route::resource('investasi', InvestasiController::class)->except(['show']);
    Route::resource('sedekah', SedekahController::class)->except(['show']);
});
