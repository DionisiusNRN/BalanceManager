<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Middleware\JWTMiddleware;

Route::prefix('v1')->group(function () {

    // Handle auth (tanpa tampilan browser, hanya API)
    Route::post('register', [JWTAuthController::class, 'register']);
    Route::post('login', [JWTAuthController::class, 'login']);

    // Middleware JWT untuk transaksi
    Route::middleware(JWTMiddleware::class)->prefix('transactions')->group(function () {
        Route::get('/', [TransactionController::class, 'index']); // Ambil semua transaksi
        Route::post('/', [TransactionController::class, 'store']); // Simpan transaksi baru
        Route::get('{id}', [TransactionController::class, 'show']); // Ambil detail transaksi
        Route::put('{id}', [TransactionController::class, 'update']); // Update transaksi
        Route::delete('{id}', [TransactionController::class, 'destroy']); // Hapus transaksi
    });
});
