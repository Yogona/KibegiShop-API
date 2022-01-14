<?php

namespace App\Http\Controllers;

use App\Models\PaymentProfile;
use Illuminate\Http\Request;

class PaymentProfileController extends Controller
{
    private function hasValidData(Request $request){
        if(
            empty($request->payment_name) ||
            empty($request->client_names) ||
            empty($request->address_one) ||
            empty($request->acc_id)
        ){
            return true;
        }
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
       if(!$this->hasValidData($request)){
            return response()->json(
                [
                    'status' => '403'
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentProfile  $paymentProfile
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentProfile $paymentProfile)
    {
        //
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
