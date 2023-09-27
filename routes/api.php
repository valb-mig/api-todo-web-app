<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskConstroller;

use Illuminate\Support\Facades\Auth;

// Connect

Route::get('/', function(){
    return response()->json([
        'connect' => true,
    ]);
});

// User

Route::middleware('check.token')->group(function () {
    Route::post('/user', [UserController::class, 'userData']);
});

Route::post('/user/login',    [UserController::class, 'userLogin']);
Route::post('/user/register', [UserController::class, 'userRegister']); 

Route::middleware('check.token')->group(function () {

    // Projects
    
    Route::post('/project',        [ProjectController::class, 'getProjects']);
    Route::post('/project/add',    [ProjectController::class, 'addProject']);
    Route::post('/project/remove', [ProjectController::class, 'removeProject']);
    Route::post('/project/edit',   [ProjectController::class, 'editProject']);
    
    // Tasks

    Route::post('/task',        [TaskConstroller::class, 'getTasks']);
    Route::post('/task/add',    [TaskConstroller::class, 'addTask']);
    Route::post('/task/remove', [TaskConstroller::class, 'removeTask']);
    Route::post('/task/edit',   [TaskConstroller::class, 'editTask']);
});