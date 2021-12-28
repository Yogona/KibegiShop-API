<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Role::factory()->create();
        $role = Role::create(
            [
                'name' => 'Seller',
                'description' => 'Register as a seller to present your business and products online and increase sales',
            ]
        );

        $role = Role::create(
            [
                'name' => 'Buyer',
                'description' => 'Register as a buyer and explore a variety of products online then make your purchase with ease.',
            ]
        );
    }
}
