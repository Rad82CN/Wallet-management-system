<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepositRequest;
use App\Http\Requests\WithdrawRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use TransactionFactory;

class TransactionController extends Controller
{
    public function showTransactions(Wallet $wallet)
    {
        $transactions = $wallet->transactions();
        return resolve(TransactionResource::class)->collection($transactions);
    }

    public function withdraw(Wallet $wallet, WithdrawRequest $request)
    {
        $factory = resolve(TransactionFactory::class)->create($request->method);

        $factory->createWithdraw($wallet, $request);
    }

    public function deposit(Wallet $wallet, DepositRequest $request)
    {
        $factory = resolve(TransactionFactory::class)->create($request->method);

        $factory->createDeposit($wallet, $request);
    }
}
