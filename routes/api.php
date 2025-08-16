<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelIgnition\Http\Requests\UpdateConfigRequest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Auth routes
Route::post('/register' , [AuthController::class , 'register'])->name('register');
Route::post('/login' , [AuthController::class , 'authenticate'])->name('login');

// Transaction routes
Route::get('/transactions/{wallet}' , [TransactionController::class , 'showTransactions'])->name('showTransactions');
Route::post('/withdraw/{wallet}' , [TransactionController::class , 'withdraw'])->name('withdraw');
Route::post('/deposit/{wallet}' , [TransactionController::class , 'deposit'])->name('deposit');



// Wallet routes
Route::get('/show-wallet/{wallet}' , [WalletController::class , 'showWallet'])->name('showWallet');

// Admin routes
Route::middleware(['admin'])->group(function() {
    Route::get('/admin/{user}' , [AdminController::class , 'isAdmin'])->name('isAdmin');
    Route::get('/admin/show-users' , [AdminController::class , 'showUsers'])->name('showUsers');
    Route::get('/admin/show-wallets' , [AdminController::class , 'showWallets'])->name('showWallets');

    // Admin Transaction routes
    Route::put('/update-request-status-reject/{transaction}' , [AdminTransactionController::class , 'updateStatusReject'])->name('updateStatusReject');
    Route::put('/update-withdraw-request-status-accept/{transaction}' , [AdminTransactionController::class , 'updateWithdrawStatusAccept'])->name('updateWithdrawStatusAccept');
    Route::put('/update-deposit-request-status-accept/{transaction}' , [AdminTransactionController::class , 'updateDepositStatusAccept'])->name('updateDepositStatusAccept');
});