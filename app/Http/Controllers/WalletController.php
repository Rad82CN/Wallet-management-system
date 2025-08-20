<?php

namespace App\Http\Controllers;

use App\Http\Resources\WalletResource;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function showAll()
    {
        $this->authorize('viewAny');

        $wallets = Wallet::all();

        return WalletResource::collection($wallets);
    }
    
    public function showOne(Wallet $wallet)
    {
        $this->authorize('view', $wallet);
        
        return WalletResource::make($wallet);
    }
}
