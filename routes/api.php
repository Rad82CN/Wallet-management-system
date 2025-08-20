<?php

use App\Http\Controllers\AclController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;
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
Route::prefix('auth')
    ->group(function() {
        Route::post('/register' , [AuthController::class , 'register'])->name('register');
        Route::post('/login' , [AuthController::class , 'login'])->name('login');
        Route::post('/profile' , [AuthController::class , 'profile'])->name('profile');
        Route::post('/logout' , [AuthController::class , 'logout'])->name('logout');
    });

// Transaction routes
Route::get('/transactions/{wallet}' , [TransactionController::class , 'showTransactions'])->name('showTransactions');
Route::post('/withdraw/{wallet}' , [TransactionController::class , 'withdraw'])->name('withdraw');
Route::post('/deposit/{wallet}' , [TransactionController::class , 'deposit'])->name('deposit');



// Wallet routes
Route::get('/show-wallet/{wallet}' , [WalletController::class , 'showOne'])->name('showOneWallet');
Route::get('/show-all-wallets' , [WalletController::class , 'showAll'])->name('showAllWallets');

// Admin routes
Route::prefix('admin')
    ->group(function() {
        Route::get('/{user}' , [AdminController::class , 'isAdmin'])->name('isAdmin');
        Route::get('/show-users' , [AdminController::class , 'showUsers'])->name('showUsers');
        Route::get('/show-wallets' , [AdminController::class , 'showWallets'])->name('showWallets');

        // Admin Transaction routes
        Route::put('/update-request-status-reject/{transaction}' , [AdminTransactionController::class , 'updateStatusReject'])->name('updateStatusReject');
        Route::put('/update-withdraw-request-status-accept/{transaction}' , [AdminTransactionController::class , 'updateWithdrawStatusAccept'])->name('updateWithdrawStatusAccept');
        Route::put('/update-deposit-request-status-accept/{transaction}' , [AdminTransactionController::class , 'updateDepositStatusAccept'])->name('updateDepositStatusAccept');
    });

Route::get('/acl/proxy/get/{url}' , [AclController::class , 'getURL'])->where('url', '.*')->name('getURL');
Route::post('/acl/proxy/post/{url}' , [AclController::class , 'postURL'])->where('url', '.*')->name('postURL');

Route::get('/test' , [TestController::class , 'test'])->middleware('auth:api')->name('test');