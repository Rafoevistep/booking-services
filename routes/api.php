<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Services\ServiceBookingController;
use App\Http\Controllers\Services\ServiceController;
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
    //Create Service
    Route::post('services', [ServiceController::class, 'store']);
    Route::put('services/{id}', [ServiceController::class, 'update']);
    Route::delete('services/{id}', [ServiceController::class, 'destroy']);
    //Writer can view booked services
    Route::get('booking',[ServiceBookingController::class, 'index']);
    Route::get('booking/{id}',[ServiceBookingController::class , 'show']);
});


Route::group(['middleware' => ['admin','auth:sanctum']], function () {
    Route::post('user' , [UserController::class , 'store']);
    Route::delete('user/{id}', [UserController::class,'destroy' ]);
    //admin can delete booked services
    Route::delete('/booking/{id}', [ServiceBookingController::class, 'destroy']);
});

//Routes For not auth users
Route::post('login', [AuthController::class, 'login']);

Route::get('services', [ServiceController::class,'index']);
Route::get('services/{id}', [ServiceController::class, 'show']);

Route::post('booking/{id}',[ServiceBookingController::class, 'store']);
Route::get('booking/search/{booking}',[ServiceBookingController::class,'search']);

