<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;

class UserController extends Controller
{
    public function getUser($id){
        $user = User::find($id);

        if(!$user){
            return response()->json([
                'status' => '204',
                'message' => 'User was not found.',
            ]);
        }

        return response()->json([
            'status' => '200',
            'message' => 'User was found successfully.',
            'body' => $user,
        ]);
    }
}
