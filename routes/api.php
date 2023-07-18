<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;

use Illuminate\Support\Facades\Auth;

// Connect

Route::get('/', function(){
    return response()->json([
        'connect' => true,
    ]);
});

// User

Route::post('/user',     [userController::class, 'getData']);

Route::post('/login',    [userController::class, 'login']);
Route::post('/register', [userController::class, 'register']); 


// Projects

Route::post('/project',        [ProjectController::class, 'getProjects']);
Route::post('/project/add',    [ProjectController::class, 'addProject']);
Route::post('/project/remove', [ProjectController::class, 'removeProject']);
Route::post('/project/edit',   [ProjectController::class, 'editProject']);

// Tasks