<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//My Controller classes
use \App\Http\Controllers\Auth\AuthController;
use \App\Http\Controllers\RoleController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\PaymentProfileController;
use \App\Http\Controllers\BusinessProfileController;

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

//Roles
Route::get('/roles', [RoleController::class, 'index']);

//Authentication
Route::post('/signout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/signin', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'register']);
Route::get('/verify_email/{user}/{token}', [AuthController::class, 'verifyEmail']);

//User
Route::prefix('/profile/user')->group(function(){
    Route::get('/{user_id}', [UserController::class, 'getUser']);
    Route::put('/update/{user_id}', [UserController::class, 'updateProfile']);
    Route::delete('/delete/{user_id}', [UserController::class, 'deleteUser']);
    Route::patch('/disable/{user_id}', [UserController::class, 'disableUser']);
});

//Payment Profile
Route::prefix('/profile/payment')->group(function (){
    Route::post('/add', [PaymentProfileController::class, 'store']);
    Route::get('/view', [PaymentProfileController::class, 'showProfiles']);
    Route::get('/view/{id}', [PaymentProfileController::class, 'showProfile']);
    Route::put('/update/{id}', [PaymentProfileController::class, 'update']);
    Route::delete('/delete/{id}', [PaymentProfileController::class, 'destroy']);
});

//Business Profile
Route::prefix('/profile/business')->group(function (){
    Route::post('/add', [BusinessProfileController::class, 'store']);
    Route::get('/view/{id}', [BusinessProfileController::class, 'show']);
    Route::patch('/update/{id}', [BusinessProfileController::class, 'update']);
});

//Default response
Route::fallback(function (){
    return response()->json(
        [
            'status' => '404',
            'message' => 'Not Found!'
        ], 404
    );
});
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
