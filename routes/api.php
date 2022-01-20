<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//My Controller classes
use \App\Http\Controllers\Auth\AuthController;
use \App\Http\Controllers\RoleController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\PaymentProfileController;

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
Route::post('/signout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/signin', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'register']);
Route::get('/verify_email/{user}/{token}', [AuthController::class, 'verifyEmail']);

//User
Route::prefix('/profile/user')->group(function(){
    Route::get('/{user_id}', [UserController::class, 'getUser']);
    Route::put('/update', [UserController::class, 'updateProfile']);
    Route::delete('/delete', [UserController::class, 'deleteUser']);
    Route::put('/disable', [UserController::class, 'disableUser']);
});

//Payment Profile
Route::prefix('/profile/payment')->group(function (){
    Route::post('/add', [PaymentProfileController::class, 'store']);
    Route::get('/view', [PaymentProfileController::class, 'showProfiles']);
    Route::get('/view/{id}', [PaymentProfileController::class, 'showProfile']);
});

//Roles
Route::get('/roles', [RoleController::class, 'index']);

//Default response
Route::fallback(function (){
    return response()->json(
        [
            'status' => '404',
            'message' => 'Not Found'
        ], 404
    );
});
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
