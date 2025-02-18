<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



// Halaman login & register
Route::get('login', [AuthController::class, 'login']);
Route::post('login', [AuthController::class, 'authenticate']);
Route::get('logout', [AuthController::class,'logout']);
Route::get('register', [AuthController::class, 'register_form']);
Route::post('register', [AuthController::class, 'register']);

// Logout (harus pakai POST karena Laravel menangani logout dengan method POST)
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [TransactionController::class,'store'])->name('transactions.store');
    Route::get('/transactions/{id}', [TransactionController::class,'show'])->name('transactions.show');
    Route::get('/transactions/{id}/edit', [TransactionController::class,'edit'])->name('transactions.edit');
    Route::put('/transactions/{id}', [TransactionController::class,'update'])->name('transactions.update');
    Route::delete('/transactions/{id}', [TransactionController::class,'destroy'])->name('transactions.destroy');
});
