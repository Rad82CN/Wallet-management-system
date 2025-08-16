<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResourse;
use App\Http\Resources\WalletResource;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function isAdmin(User $user)
    {
        if($user->role !== 'admin')
        {
            return "Not authorized";
        }
        
        return $user->name . " is admin";
    }

    public function showUsers()
    {
        $users = User::all();
        
        return resolve(UserResourse::class)->collection($users);
    }

    public function showWallets()
    {
        $wallets = Wallet::all();

        return resolve(WalletResource::class)->collection($wallets);
    }
}
