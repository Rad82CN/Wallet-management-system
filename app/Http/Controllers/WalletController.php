<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function showWallet(Wallet $wallet)
    {
        return resolve(Wallet::class)->make($wallet);
    }
}
