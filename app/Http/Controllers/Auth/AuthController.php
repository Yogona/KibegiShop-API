<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use \App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request){
       foreach($request->all() as $field){
           if(empty($field))
           return response()->json([
               'status' => '400',
               'message' => 'Empty field(s) were provided.',
               'body' => $request->all(),
           ]);
       }

       $user = new User();
       $user->username = $request->input('username');
       $pwd = $request->input('password');
       $user->password = Hash::make($pwd);
       $user->f_name = $request->input('f_name');
       $user->m_name = $request->input('m_name');
       $user->l_name = $request->input('l_name');
       $user->gender = $request->input('gender');
       $user->nationality = $request->input('nationality');
       $user->email = $request->input('email');
       $user->phone = $request->input('phone');
       $user->address = $request->input('address');
       $user->is_active = false;
       $user->role_id = $request->input('role_id');

       $user->save();

       $token = $user->createToken($request->device_name)->plainTextToken;

       return response()->json([
           'status' => '200',
           'message' => 'User was created successfully.',
           'body' => [
               'user' => $user,
               'token' => $token,
           ]
       ]);
    }
}
