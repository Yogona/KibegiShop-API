<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    private function hasValidData(Request $request){
        //Check emptiness
        if(
            empty($request['f_name'])   ||
            empty($request['m_name'])   ||
            empty($request['l_name'])   ||
            empty($request['gender'])   ||
            empty($request['nationality'])||
            empty($request['email'])    ||
            empty($request['phone'])    ||
            empty($request['address'])
        ){
            return false;
        }

        return true;
    }

    public function updateProfile(Request $request){
        $user = User::find($request->id);

        if($user){
            if(!Gate::forUser($request->user())->check('update-user', $user)){
                return response()->json([
                    'status' => '403',
                    'message' => 'You can not update this user.',
                ]);
            }
        }

        if(!$user){
            return response()->json([
                'status' => '204',
                'message' => 'User was not found.',
            ]);
        }

        try{
            $isValid = $this->hasValidData($request);

            if(!$isValid){    
                return response()->json([    
                    'status' => '400',    
                    'message' => 'Check your input fields.',    
                    'body' => $request->all(),    
                ]);
            }

            $user->f_name = $request->f_name;
            $user->m_name = $request->m_name;
            $user->l_name = $request->l_name;
            $user->gender = $request->gender;
            $user->nationality = $request->nationality;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->save();

            return response()->json([
                'status' => '200',
                'message' => 'User was updated successfully.',
                'body' => [
                    'user' => $user,
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

    public function getUser(Request $request, $id){
        $searchUser = User::find($id);
       
        if($searchUser){
            if(!Gate::forUser($request->user())->check('view-user', $searchUser)){
                return response()->json([
                    'status' => '403',
                    'message' => 'You can not view this user.',
                ]);
            }
        }

        if(!$searchUser){
            return response()->json([
                'status' => '204',
                'message' => 'User was not found.',
            ]);
        }

        return response()->json([
            'status' => '200',
            'message' => 'User was found successfully.',
            'body' => $searchUser,
        ]);
    }
}