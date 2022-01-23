<?php

namespace App\Http\Controllers;

use App\Models\BusinessProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class BusinessProfileController extends Controller
{
    private $serverError = "Internal server error.";

    public function __construct(){
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            if(!Gate::check('add-business-profile', $request->user())){
                return response()->json(
                    [
                        'status' => '403',
                        'message' => 'Only sellers can have a business profile.',
                    ], 403
                );
            }

            $validation = Validator::make(
                $request->all(),
                [
                    'tin_no' => 'required|integer|min:9|unique:business_profiles',
                ]
            );

            if($validation->fails()){
                return response()->json(
                    [
                        'status' => '400',
                        'message' => 'Check your input fields.',
                        'body' => $validation->errors(),
                    ], 400
                );
            }

            $hasBusinessProfile = $request->user()->businessProfile()->first();
            
            if($hasBusinessProfile){
                return response()->json(
                    [
                        'status' => '400',
                        'message' => "You can't have more than one business profile.",
                    ], 400
                );
            }

            $businessProfile = BusinessProfile::create(
                [
                    'tin_no' => $request->tin_no,
                    'user_id' => $request->user()->id,
                ]
            );

            return response()->json(
                [
                    'status' => '201',
                    'message' => 'Business profile was added successfully.',
                    'body' => $businessProfile,
                ], 201
            );

        }catch(\Exception $exc){
            return response()->json(
                [
                    'status' => '500',
                    'message' => $this->serverError,
                ], 500
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BusinessProfile  $businessProfile
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        try{
            $businessProfile = BusinessProfile::find($id);

            if($businessProfile){
                if(!Gate::forUser($request->user())->check('view-business-profile', $businessProfile)){
                    return response()->json(
                        [
                            'status' => '403',
                            'message' => "You can't view this business profile.",
                        ], 403
                    );
                }
            }else{
                return response()->json(
                    [
                        'status' => '404',
                        'message' => 'Business profile does not exist.',
                    ], 404
                );
            }

            return response()->json(
                [
                    'status' => '200',
                    'message' => 'Business profile was found successfully.',
                    'body' => $businessProfile,
                ], 200
            );
        }catch(\Exception $exc){
            return response()->json(
                [
                    'status' => '500',
                    'message' => $this->serverError,
                    'body' => $exc,
                ], 500
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BusinessProfile  $businessProfile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $businessProfile = BusinessProfile::find($id);

            if($businessProfile){
                if(!Gate::forUser($request->user())->check('update-business-profile', $businessProfile)){
                    return response()->json(
                        [
                            'status' => '403',
                            'message' => "You can't update this business profile.",
                        ], 403
                    );
                }
            }else{
                return response()->json(
                    [
                        'status' => '404',
                        'message' => 'Business profile does not exist.',
                    ], 404
                );
            }

            $validation = Validator::make(
                $request->all(),
                [
                    'tin_no' => 'required|integer|min:9|unique:business_profiles'
                ]
            );

            if($validation->fails()){
                return response()->json(
                    [
                        'status' => '400',
                        'message' => 'Please check your input.',
                        'body' => $validation->errors(),
                    ], 400
                );
            }

            $businessProfile->update(
                [
                    'tin_no' => $request->tin_no,
                ]
            );

            return response()->json(
                [
                    'status' => '200',
                    'message' => 'Business profile was updated successfully.',
                    'body' => $businessProfile,
                ]
            );
        }catch(\Exception $exc){
            return response()->json(
                [
                    'status' => '500',
                    'message' => $this->serverError,
                    'body' => $exc,
                ], 500
            );
        }
    }
}
