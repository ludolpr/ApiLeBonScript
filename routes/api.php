<?php

use App\Http\Controllers\API\AnnouncementController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// auth route
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
//Seulement accessible via le JWT
Route::middleware('auth:api')->group(function () {
    Route::get('/currentuser', [UserController::class, 'currentUser']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
    



// Route::apiResource("users", UserController::class);
Route::apiResource("announcement", AnnouncementController::class);
Route::apiResource("category", CategoryController::class);
Route::apiResource("role", RoleController::class);
Route::apiResource("message", MessageController::class);