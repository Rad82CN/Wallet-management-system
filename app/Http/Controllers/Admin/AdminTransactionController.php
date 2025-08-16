<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\WalletResource;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AdminTransactionController extends Controller
{
    public function updateStatusReject(Transaction $transaction)
    {
        $transaction->status = Transaction::STATUS_REJECTED;
        $transaction->save();

        return resolve(TransactionResource::class)->make($transaction);
    }

    public function updateWithdrawStatusAccept(Transaction $transaction)
    {
        try {
            DB::beginTransaction();

            if($transaction->amount < 1000) {
                return "amount must be above 1000";
            }

            $transaction->status = Transaction::STATUS_ACCEPTED;
            $wallet = $transaction->wallet;
            $wallet->balance -= $transaction->amount;
            $wallet->save();
            $transaction->save();

            DB::commit();
        }
        catch(\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return response('has error' , Response::HTTP_INTERNAL_SERVER_ERROR)->getMessage();
        }
        return [
            resolve(TransactionResource::class)->make($transaction),
            resolve(WalletResource::class)->make($wallet),
        ];
    }

    public function updateDepositStatusAccept(Transaction $transaction)
    {
        try {
            DB::beginTransaction();

            if($transaction->amount < 1000) {
                return "amount must be above 1000";
            }

            $transaction->status = Transaction::STATUS_ACCEPTED;
            $wallet = $transaction->wallet;
            $wallet->balance += $transaction->amount;
            $wallet->save();
            $transaction->save();

            DB::commit();
        }
        catch(\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return response('has error' , Response::HTTP_INTERNAL_SERVER_ERROR)->getMessage();
        }
        return [
            resolve(TransactionResource::class)->make($transaction),
            resolve(WalletResource::class)->make($wallet),
        ];
    }
}
