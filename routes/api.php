<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Classes
use \App\Http\Controllers\Auth\AuthController;
use \App\Http\Controllers\RoleController;
use \App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Authentication
Route::post('/signout', [AuthController::class, 'logout']);
Route::post('/signin', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'register']);
Route::get('/verify_email/{user}/{token}', [AuthController::class, 'verifyEmail']);

//User
Route::middleware('auth:sanctum')->get('/profile/user/{user_id}', [UserController::class, 'getUser']);
Route::middleware('auth:sanctum')->put('/profile/user/update', [UserController::class, 'updateProfile']);

//Roles
Route::get('/roles', [RoleController::class, 'index']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
