<?php

namespace App\Services\TransactionStrategy;

use App\Models\Transaction;
use App\Services\TransactionStrategy\TransactionMethod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Cbc implements TransactionMethod
{
    public function deposit($wallet, $request)
    {
        try {
            DB::beginTransaction();

            $transaction = Transaction::create([
                'amount' => $request->amount,
                'wallet_id' => $wallet->id,
                'type' => Transaction::TYPE_DEPOSIT,
                'status' => Transaction::STATUS_ACCEPTED,
                'method' => Transaction::METHOD_CBC,
            ]);

            $wallet->balance += $transaction->amount;
            $wallet->save();

            DB::commit();
        } 
        catch(\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return response('has error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function withdraw($wallet, $request)
    {
        try {
            DB::beginTransaction();

            $transaction = Transaction::create([
                'amount' => $request->amount,
                'wallet_id' => $wallet->id,
                'type' => Transaction::TYPE_WITHDRAW,
                'status' => Transaction::STATUS_ACCEPTED,
                'method' => Transaction::METHOD_CBC,
            ]);

            $wallet->ballance -= $transaction->amount;
            $wallet->save();

            DB::commit();
        }
        catch(\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return response('has error' , Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}