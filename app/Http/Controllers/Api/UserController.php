<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function userData(Request $request)
    {
        $token = $request->header('Authorization');
        $user  = User::where('remember_token', $token)->first();

        return response()->json([
            'success' => true,
            'user'    => [
                'name' => $user->username
            ]
        ], 200);
    }

    public function userLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);
    
        if ( $user = User::where('username', $credentials['username'])->first() )
        {
            if ( Hash::check($credentials['password'], $user->hash) ) 
            {
                $token = $user->createToken('laravelSessionToken')->plainTextToken;

                $user->remember_token = $token;
                $user->updated_at = now();
                $user->save();

                return response()->json([
                    'success' => true,
                    'remember_token' => $token
                ], 200);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => "Wrong password"
                ], 401);
            }
        }
        else 
        {
            return response()->json([
                'success' => false,
                'message' => "User don't exists"
            ], 404);
        }
    }

    public function userRegister(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);  

        if(!User::where('username', $credentials['username'])->first())
        {
            $user = new User();

            $user->username       = $credentials['username'];
            $user->hash           = Hash::make($credentials['password']);
            $user->updated_at     = now();
            $user->created_at     = now();
    
            $user->save();
    
            $token = $user->createToken('laravelSessionToken')->plainTextToken;
    
            return response()->json([
                'success' => true,
                'remember_token' => $token
            ], 201);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => "User already exists"
            ], 304);  
        }
    }
}
