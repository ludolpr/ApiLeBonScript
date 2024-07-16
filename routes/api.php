<?php

use App\Http\Controllers\API\AnnouncementController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource("users", UserController::class);
Route::apiResource("announcement", AnnouncementController::class);
Route::apiResource("Category", CategoryController::class);
Route::apiResource("Role", RoleController::class);
