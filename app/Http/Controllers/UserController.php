<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
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