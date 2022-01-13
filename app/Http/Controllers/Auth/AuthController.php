<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use \App\Models\User;
use \App\Mail\AccountVerification;

class AuthController extends Controller
{
    public function logout(Request $request){
        $user = User::find($request->input('user_id'));
        
        if(!$user){
            return response()->json([
                'status' => '204',
                'message' => 'User no longer exists!',
            ]);
        }

        $user->tokens()->delete();

        return response()->json([
            'status' => '200',
            'message' => 'User logged out successfully',
        ]);
    }

    public function login(Request $request){
        $userId = DB::table('users')->where('username', $request->username)->orWhere('phone', $request->username)->orWhere('email', $request->username)->first()->id;
        $user = User::find($userId);
        
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'status' => '204',
                'message' => 'Credentials do not match any record.',
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

    public function verifyEmail(Request $request, $user, $token){
        $user = User::find($user);
        $token = Hash::make($token);

        if(!$user){
            return view('email_verification')->with('message', 'Verification link expired.');
        }


        $user->is_active = true;
        $user->email_verified_at = now();
        $user->updated_at = now();
        $user->save();

        return view('email_verification')->with('message', "Email was verified successfully.");
    }

    private function hasValidData(Request $request){
        //Check emptiness
        if(
            empty($request['username']) ||
            empty($request['password']) ||
            empty($request['f_name'])   ||
            empty($request['m_name'])   ||
            empty($request['l_name'])   ||
            empty($request['gender'])   ||
            empty($request['nationality'])||
            empty($request['email'])    ||
            empty($request['phone'])    ||
            empty($request['address'])  ||
            empty($request['role_id'])
        ){
            return false;
        }

        return true;
    }

    private function sendVerificationEmail(User $user, $token){
        Mail::to($user->email)->send(new AccountVerification($user->id, $token));
    }

    public function register(Request $request){
        try{
            $isValid = $this->hasValidData($request);

            if(!$isValid){    
                return response()->json([    
                    'status' => '400',    
                    'message' => 'Check your input fields.',    
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
            ]);
        }catch(\Exception $exc){
            return response()->json([
                'status' => '500',
                'message' => "Internal server error.",
                'body' => $exc
            ]);
        }
    }
}
