<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;

Route::post('/login',    [userController::class, 'login']); 
Route::post('/register', [userController::class, 'register']); 

Route::get('/', function(){
    return response()->json([
        'connect' => true,
    ]);
});