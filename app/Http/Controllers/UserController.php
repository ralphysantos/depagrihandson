<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::create($request->all());

        return response()->json([
            'user' => $user
        ],201);
    }

    public function assignRole(Request $request, $id){
        $user = User::find($id);

        if(!$user){
            return response()->json([
                'message' => 'User not found'
            ],404);
        }

        $user->role = $request->role;
        $user->save();

        return response()->json([
            'user' => $user
        ],200);
    }
}
