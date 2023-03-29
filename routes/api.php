<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'auth'], function ($router) {
    // Define routes that require authentication here
    Route::get('me', [AuthController::class, 'me']);
    Route::get('logout', [AuthController::class, 'logout']);
    //User Data all
    Route::get('user' , [UserController::class , 'index']);
    Route::get('user/{id}',[UserController::class , 'show']);
    Route::put('user/update/profile', [UserController::class, 'update_profile']);
    Route::put('user/update/password', [UserController::class, 'update_password']);
});

Route::group(['middleware' => ['admin','auth:sanctum']], function () {
    Route::post('user' , [UserController::class , 'store']);
    Route::delete('user/{id}', [UserController::class,'destroy' ]);
});

Route::post('login', [AuthController::class, 'login']);
