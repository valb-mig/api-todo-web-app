<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

        if($user)
        {
            if(Hash::check($credentials['password'], $user->hash)) 
            {
                $token = $user->createToken('token')->plainTextToken;

                return response()->json([
                    'success' => true,
                    'message' => "User logged",
                    'token'   => $token
                ]);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => "Wrong password",
                ]);
            }
        }
        else 
        {
            return response()->json([
                'success' => false,
                'message' => "User don't exists",
            ]);
        }
    }

    public function register(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $exists = User::where('username', $credentials['username'])->exists();
        
        $user = new User();

        if (!$exists) 
        {
            $user->username = $credentials['username'];
            $user->hash = Hash::make($credentials['password']);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'User registered successfully',
            ]);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'User already exists',
            ]);
        }
    }
}
