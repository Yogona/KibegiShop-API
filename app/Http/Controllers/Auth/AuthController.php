<?php

namespace App\Http\Controllers\Auth;

use \App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use \App\Models\User;
use \App\Mail\AccountVerification;

class AuthController extends Controller
{
    private $serverError = "Internal server error.";

    public function logout(Request $request){
        try{
            $request->user()->tokens()->delete();

            return response()->json([
                'status' => '200',
                'message' => 'User logged out successfully',
            ], 200);
        }catch(\Exception $exc){
            return response()->json(
                [
                    'status' => '500',
                    'message' => $serverError,
                ],500
            );
        }
    }

    public function login(Request $request){
        try{
            $userId = DB::table('users')->where('username', $request->username)->orWhere('phone', $request->username)->orWhere('email', $request->username)->first()->id;
            $user = User::find($userId);
            
            if(!$user || !Hash::check($request->password, $user->password)){
                return response()->json([
                    'status' => '200',
                    'message' => 'Credentials do not match any record.',
                ], 200);
            }else if(!$user->is_active){
                return response()->json([
                    'status' => '204',
                    'message' => 'Your account is inactive.',
                ], 200);
            }

            $token = $user->createToken($request->device_name)->plainTextToken;

            return response()->json([
                'status' => '200',
                'message' => "User has been logged in successfully!",
                'body' => [
                    'user' => $user,
                    'token' => $token,
                ],
            ], 200);
        }catch(\Exception $exc){
            return response()->json(
                [
                    'status' => '500',
                    'message' => $serverError,
                ], 500
            );
        }
    }

    public function verifyEmail(Request $request, $user, $token){
        try{
            $user = User::find($user);

            if(!$user){
                return view('email_verification')->with('message', 'Verification link expired.');
            }

            $user->is_active = true;
            $user->email_verified_at = now();
            $user->updated_at = now();
            $user->save();

            return view('email_verification')->with('message', "Email was verified successfully.");
        }catch(\Exception $exc){
            return response()->json(
                [
                    'status' => '500',
                    'message' => $serverError,
                ], 500
            );
        }
    }

    private function sendVerificationEmail(User $user, $token){
        Mail::to($user->email)->send(new AccountVerification($user->id, $token));
    }

    public function register(Request $request){
        try{
            $validation = Validator::make(
                $request->all(),
                [
                    'username' => 'required|unique:users,username|max:60',
                    'password' => 'required',
                    'confirm_password' => 'required|same:password',
                    'first_name' => 'required|alpha|regex:/^[A-Z]/',
                    'middle_name' => 'alpha|regex:/^[A-Z]/',
                    'last_name' => 'required|alpha|regex:/^[A-Z]/',
                    'gender' => 'required|alpha|max:1|regex:/^[M,F]/',
                    'nationality' => 'required|max:100|alpha',
                    'email' => 'required|email|unique:users,email',
                    'phone' => 'required|numeric|max:9000000000000000|unique:users,phone',
                    'address' => 'required',
                    'role_id' => 'required|numeric'
                ]
            );

            if($validation->fails()){    
                return response()->json([    
                    'status' => '400',    
                    'message' => 'Check your input fields.',    
                    'body' => $validation->errors(),    
                ], 400);
            }

            $user = new User();
            $user->username = $request->input('username');
            $pwd = $request->input('password');
            $user->password = Hash::make($pwd);
            $user->f_name = $request->input('first_name');
            $user->m_name = $request->input('middle_name');
            $user->l_name = $request->input('last_name');
            $user->gender = $request->input('gender');
            $user->nationality = $request->input('nationality');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->address = $request->input('address');
            $user->role_id = $request->input('role_id');
            $user->save();

            $token = $user->createToken($request->device_name)->plainTextToken;

            $this->sendVerificationEmail($user, $token);

            return response()->json([
                'status' => '200',
                'message' => 'User was created successfully.',
                'body' => [
                    'user' => $user,
                    'token' => $token,
                ]
            ], 200);
        }catch(\Exception $exc){
            return response()->json([
                'status' => '500',
                'message' => "Internal server error.",
            ], 500);
        }
    }
}
