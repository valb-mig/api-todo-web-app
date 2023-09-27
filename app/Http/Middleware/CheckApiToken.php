<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApiToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');

        if(!$token || empty($token))
        {
            return response()->json([
                'success' => false,
                'message' => "Token not provided"
            ], 401);
        }

        $user = User::where('remember_token', $token)->first();

        if(!$user || empty($user))
        {
            return response()->json([
                'success' => false,
                'message' => "Invalid token"
            ], 401);
        }

        return $next($request);
    }
}
