<?php

namespace App\Services\TransactionStrategy;

use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Services\TransactionStrategy\TransactionMethod;

class Sheba implements TransactionMethod
{
    public function deposit($wallet, $request)
    {
        $transaction = Transaction::create([
            'amount' => $request->amount,
            'wallet_id' => $wallet->id,
            'type' => Transaction::TYPE_DEPOSIT,
            'method' => Transaction::METHOD_SH,
        ]);

        return resolve(TransactionResource::class)->make($transaction);
    }

    public function withdraw($wallet, $request)
    {
        $transaction = Transaction::create([
            'amount' => $request->amount,
            'wallet_id' => $wallet->id,
            'type' => Transaction::TYPE_WITHDRAW,
            'method' => Transaction::METHOD_SH,
        ]);

        return resolve(TransactionResource::class)->make($transaction);
    }
}