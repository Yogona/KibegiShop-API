<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Classes
use \App\Models\Role;

class RoleController extends Controller
{
    public function index(){
        $roles =  Role::all();

        return response()->json([
            'status' => '200',
            'message' => 'Roles were retrieved successfully.',
            'body' => $roles
        ]);
    }
}
