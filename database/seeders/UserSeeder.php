<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->username = 'Yogona';
        $user->password = Hash::make('1234');
        $user->f_name = 'Yona';
        $user->m_name = 'Godwin';
        $user->l_name = 'Yona';
        $user->gender = 'M';
        $user->nationality = 'Tanzanian';
        $user->email = 'yonagodwin@gmail.com';
        $user->phone = '0712500282';
        $user->address = 'Dodoma';
        $user->is_active = '1';
        $user->role_id = '1';
        $user->save();

        $user = new User();
        $user->username = 'John';
        $user->password = Hash::make('1234');
        $user->f_name = 'John';
        $user->m_name = '';
        $user->l_name = 'Doe';
        $user->gender = 'M';
        $user->nationality = 'English';
        $user->email = 'yogona@tansoften.com';
        $user->phone = '0763765547';
        $user->address = 'Arusha';
        $user->is_active = '1';
        $user->role_id = '2';
        $user->save();
    }
}
