<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use \App\Models\User;

class AuthController extends Controller
{
    public function logout(Request $request){
        $user = User::find($request->id);

        if(!$user){
            return response()->json([
                'status' => '204',
                'message' => 'User no longer exists!',
                'body' => ''
            ]);
        }

        $user->tokens->delete();

        return reponse()->json([
            'status' => '200',
            'message' => 'User logged out successfully',
        ]);
    }

    public function login(Request $request){
        $user = DB::table('users')->where('username', $request->username)->orWhere('phone', $request->username)->orWhere('email', $request->username)->first();
        
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'status' => '204',
                'message' => 'Credentials do not match any records.',
                'body' => ''
            ]);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'status' => '200',
            'message' => "User has been logged in successfully!",
            'body' => [
                'user' => $user,
                'token' => $token,
            ],
        ]);
    }

    public function verifyEmail(Request $request){
        $user = User::find($request->get('user'));
        $token = Hash::make($request->get('token'));
        if(!$user || !$user->tokens->where('token', $token)){
            return response()->json([
                'status' => '204',
                'message' => 'Sorry! The link had expired already!',
                'body' => '',
            ]);
        }

        
        $user->is_active = true;
        $user->updated_at = now();
        $user->save();

        return response()->json([
            'status' => '200',
            'message' => 'Email has been verified successfully!',
            'body' => [
                'user' => $user,
                'token' => $request->get('token'),
            ]
        ]);
    }

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
