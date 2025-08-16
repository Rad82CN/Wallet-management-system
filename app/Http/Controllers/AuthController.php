<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(UserStoreRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            $user = User::create($validated);
            $wallet = Wallet::create([
                'user_id' => $user['id'],
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return response('has error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        

        $token = $user->createToken('register')->plainTextToken;

        return [$user, $wallet, $token];
    }

    public function authenticate(UserLoginRequest $request)
    {
        $validated = $request->validated();

        if(!Auth::attempt($validated))
        {
            return "information is not valid";
        }

        $user = Auth::user();

        $token = $user->createToken('login')->plainTextToken;

        return [$user , $token];
    }
}