<?php

namespace App\Http\Controllers;

use App\Models\PaymentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentProfileController extends Controller
{
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
                        'status' => '401',
                        'body' => 'Check your input fields.',
                        'body' => $validation->errors(),
                    ]
                );
            }

            $paymentProfile = PaymentProfile::create(
                [
                'payment_name' => $request->payment_name,
                'client_names' => $request->client_names,
                'address_one' => $request->address_one,
                'address_two' => $request->address_two,
                'acc_id' => $request->acc_id,
                'user_id' => $request->user()->id,
                ]
            );

            return response()->json(
                [
                    'status' => '200',
                    'message' => 'You added a payment method successfuly.',
                    'body' => $paymentProfile,
                ]
            );
       }catch(\Exception $exc){
            return response()->json(
                [
                    'status' => '500',
                    'message' => 'Internal server error.',
                    'body' => $exc,
                ]
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
                    ]);
                }
            }else{
                return response()->json([
                    'status' => '204',
                    'message' => 'Payment profile was not found.',
                ]);
            }

            return response()->json(
                [
                    'status' => '200',
                    'message' => 'Payment profile was retrieved successfully.',
                    'body' => 'done',
                ]
            );
        }catch(\Exception $exc){
            return response()->json(
                [
                    'status' => '500',
                    'message' => 'Internal server error.',
                    'body' => $exc,
                ]
            );
        }
    }

    public function showProfiles(Request $request)
    {
        try{
            $payProfiles = PaymentProfile::where('user_id', $request->user()->id)->get();
            
            if(!$payProfiles){
                return response()->json(
                    [
                        'status' => '204',
                        'No payment profiles were found.',
                    ]
                );
            }
            
            return response()->json(
                [
                    'status' => '200',
                    'message' => 'Payment profile'.((strlen($payProfiles) > 1)?'(s) were':' was').' found.',
                    'body' => $payProfiles,
                ]
            );
        }catch(\Exception $exc){
            return response()->json(
                [
                    'status' => '500',
                    'message' => 'Internal server error.',
                    'body' => $exc,
                ]
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
    public function update(Request $request, PaymentProfile $paymentProfile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentProfile  $paymentProfile
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentProfile $paymentProfile)
    {
        //
    }
}
