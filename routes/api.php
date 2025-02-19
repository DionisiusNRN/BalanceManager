<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Auth;


Route::prefix('v1')->group(function () {
    Route::get('/', function () {
        if (Auth::check()) {
            return redirect('/transactions'); // Redirect ke transaksi jika sudah login
        } else {
            return redirect('login'); // Redirect ke login jika belum login
        }
    });

    // Handle login & register
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'authenticate']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('register', [AuthController::class, 'register_form'])->name('register');
    Route::post('register', [AuthController::class, 'register']);

    // Middleware auth untuk transaksi
    // Route::middleware(['auth'])->group(function () {
        // Handle Transactions
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
        Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
        Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
        Route::get('/transactions/{id}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
        Route::put('/transactions/{id}', [TransactionController::class, 'update'])->name('transactions.update');
        Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    // });
});
