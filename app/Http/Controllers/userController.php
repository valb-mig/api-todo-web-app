<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
    
        $user = User::where('username', $credentials['username'])->first();
    
        if (!$user || !Hash::check($credentials['password'], $user->hash)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    
        $token = $user->createToken('authToken')->plainTextToken;
    
        return response()->json([
            'message' => 'Authenticated successfully',
            'user' => $user->username,
            'token' => $token,
        ]);
    }

    public function register(Request $request)
    {
        $user = new User();
        $user->username = $request->input('username');
        $user->hash = Hash::make($request->input('password'));
        $user->save();
    
        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user->username,
        ]);
    }
}
