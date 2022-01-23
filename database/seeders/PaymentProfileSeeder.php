<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\PaymentProfile;

class PaymentProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentProfile::create(
            [
                "payment_name" => "Paypal",
                "client_names" => "Yona Godwin",
                "address_one" => "Dodoma",
                "address_two" => "",
                "acc_id" => "yonagodwin@gmail.com",
                "user_id" => "1",
            ]
        );

        PaymentProfile::create(
            [
                "payment_name" => "Paypal",
                "client_names" => "John Doe",
                "address_one" => "Dodoma",
                "address_two" => "",
                "acc_id" => "johndoe@gmail.com",
                "user_id" => "2",
            ]
        );
    }
}
