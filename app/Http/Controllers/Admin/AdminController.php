<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResourse;
use App\Http\Resources\WalletResource;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function isAdmin(User $user)
    {
        if($user->role !== 'admin')
        {
            return "Not admin";
        }
        
        return $user->name . " is admin";
    }

    public function showUsers()
    {
        $user = auth()->user();

        $users = User::all();
        
        return resolve(UserResourse::class)->collection($users);
    }

    public function showWallets()
    {
        $wallets = Wallet::all();

        return resolve(WalletResource::class)->collection($wallets);
    }
}
