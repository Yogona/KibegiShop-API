<?php

namespace App\Http\Controllers;

use App\Models\PaymentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class PaymentProfileController extends Controller
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
            $validation = Validator::make(
                $request->all(),
                [
                    'payment_name' => 'required',
                    'client_names' => 'required',
                    'address_one' => 'required',
                    'acc_id' => 'required',
                ]
            );

            if($validation->fails()){
                return response()->json(
                    [
                        'status' => '400',
                        'body' => 'Check your input fields.',
                        'body' => $validation->errors(),
                    ], 400
                );
            }

            $paymentProfile = PaymentProfile::create(
                [
                'payment_name'  => $request->payment_name,
                'client_names'  => $request->client_names,
                'address_one'   => $request->address_one,
                'address_two'   => $request->address_two,
                'acc_id'        => $request->acc_id,
                'user_id'       => $request->user()->id,
                ]
            );

            return response()->json(
                [
                    'status'    => '201',
                    'message'   => 'You added a payment method successfuly.',
                    'body'      => $paymentProfile,
                ], 201
            );
       }catch(\Exception $exc){
            return response()->json(
                [
                    'status'    => '500',
                    'message'   => $serverError,
                ], 500
            );
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentProfile  $paymentProfile
     * @return \Illuminate\Http\Response
     */

    public function showProfile(Request $request, $paymentId){
        try{
            $paymentProfile = PaymentProfile::find($paymentId);

            if($paymentProfile){
                if(!Gate::forUser($request->user())->check('view-pay-profile', $paymentProfile)){
                    return response()->json([
                        'status' => '403',
                        'message' => 'You can not view this payment profile.',
                    ], 403);
                }
            }else{
                return response()->json([
                    'status' => '404',
                    'message' => 'Payment profile was not found.',
                ], 404);
            }

            return response()->json(
                [
                    'status' => '200',
                    'message' => 'Payment profile was retrieved successfully.',
                    'body' => $paymentProfile,
                ], 200
            );
        }catch(\Exception $exc){
            return response()->json(
                [
                    'status' => '500',
                    'message' => $serverError,
                ], 500
            );
        }
    }

    public function showProfiles(Request $request)
    {
        try{
            $payProfiles = PaymentProfile::where('user_id', $request->user()->id)->get();
            
            if(sizeof($payProfiles) < 1){
                return response()->json(
                    [
                        'status' => '404',
                        'message' => 'No payment profiles were found.',
                    ], 404
                );
            }
            
            return response()->json(
                [
                    'status' => '200',
                    'message' => 'Payment profile'.((sizeof($payProfiles) > 1)?'s were':' was').' found.',
                    'body' => $payProfiles,
                ], 200
            );
        }catch(\Exception $exc){
            return response()->json(
                [
                    'status' => '500',
                    'message' => $serverError,
                ], 500
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentProfile  $paymentProfile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $paymentId)
    {
        try{
            $validation = Validator::make(
                $request->all(),
                [
                    'payment_name'  => 'required',
                    'client_names'  => 'required',
                    'address_one'   => 'required',
                    'acc_id'        => 'required',
                ]
            );

            if($validation->fails()){
                return response()->json(
                    [
                        'status'    => '400',
                        'body'      => 'Check your input fields.',
                        'body'      => $validation->errors(),
                    ], 400
                );
            }

            $payProfile = PaymentProfile::find($paymentId);

            if($payProfile){
                if(!Gate::forUser($request->user())->check('update-pay-profile', $payProfile)){
                    return response()->json(
                        [
                            'status'    => '403',
                            'message'   => 'You can not update this payment profile.',
                        ], 403
                    );
                }
            }else{
                return response()->json(
                    [
                        'status'    => '404',
                        'message'   => 'Payment profile does not exist.',
                    ], 404
                );
            }

            //Boolean value
            $updatedProfile = $payProfile->update(
                [
                    'payment_name'  => $request->payment_name,
                    'client_names'  => $request->client_names,
                    'address_one'   => $request->address_one,
                    'address_two'   => $request->address_two,
                    'acc_id'        => $request->acc_id,
                ]
            );

            return response()->json(
                [
                    'status' => '200',
                    'message' => 'Payment profile was updated successfully!',
                    'body' => $payProfile,
                ], 200
            );
        }catch(\Exception $exc){
            return response()->json(
                [
                    'status' => '500',
                    'message' => $serverError,
                ], 500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentProfile  $paymentProfile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $profileId)
    {
        try{
            $payProfile = PaymentProfile::find($profileId);

            if($payProfile){
                if(!Gate::forUser($request->user())->check('delete-pay-profile', $payProfile)){
                    return response()->json(
                        [
                            'status' => '403',
                            'message' => 'You can not delete this profile.',
                        ], 403
                    );
                }
            }else{
                return response()->json(
                    [
                        'status' => '404',
                        'message' => 'Profile does not exist.'
                    ], 404
                );
            }

            $payProfile->delete();

            return response()->json(
                [
                    'status' => '200',
                    'message' => 'Profile was remove successfully.',
                ], 200
            );
        }catch(\Exception $exc){
            return response()->json(
                [
                    'status' => '500',
                    'message' => $serverError,
                ], 500
            );
        }
    }
}
