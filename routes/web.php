<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/email_verification', [AuthController::class, 'emailVerificationStatus']);
Route::get('/login', function(){
    return response()->json([
        'status' => '401',
        'message' => 'Please login first.',
    ]);
})->name('login');