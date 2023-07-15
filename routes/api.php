<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Auth;

// Connect

Route::get('/', function(){
    return response()->json([
        'connect' => true,
    ]);
});

// User

Route::post('/login',    [userController::class, 'login']);
Route::post('/register', [userController::class, 'register']); 
Route::post('/user',     [userController::class, 'getData']);
