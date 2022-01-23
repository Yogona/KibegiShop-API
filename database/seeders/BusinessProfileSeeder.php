<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BusinessProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BusinessProfile::create(
            [
                'tin_no' => '123456789',
                'user_id' => '2',
            ]
        );
    }
}
