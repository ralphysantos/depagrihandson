<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $credentials = $request->only(['email','password']);

        if(!auth()->attempt($credentials)){
            return response()->json([
                'message' => 'Invalid User Credentials'
            ],401);
        }

        $user = auth()->user();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token
        ],201);

    }

    public function logout(){
        $user = auth()->user();

        $user->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ],200);
    }
}
