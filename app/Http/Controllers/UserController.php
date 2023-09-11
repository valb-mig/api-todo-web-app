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
            'password' => 'required|string'
        ]);
    
        if ( $user = User::where('username', $credentials['username'])->first() )
        {
            if ( Hash::check($credentials['password'], $user->hash) ) 
            {
                $token = $user->createToken('laravelSessionToken')->plainTextToken;

                $user->remember_token = $token;
                $user->updated_at = date('Y-m-d H:i:s');
                $user->save();

                return response()->json([
                    'success' => true,
                    'remember_token' => $token
                ]);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => "Wrong password"
                ]);
            }
        }
        else 
        {
            return response()->json([
                'success' => false,
                'message' => "User don't exists"
            ]);
        }
    }

    public function register(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);  

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
        ]);
    }

    public function getData(Request $request)
    {
        $token = $request->header('Authorization');
        
        if ( User::where('remember_token', $token)->exists() ) 
        {
            $user = User::where('remember_token', $token)->first();

            return response()->json([
                'success' => true,
                'user'    => [
                    'name' => $user->username
                ]
            ]);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'Invalid token'
            ]);
        }
    }
}
