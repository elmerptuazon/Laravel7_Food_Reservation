<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = array(
            [
                'fname' => 'secret',
                'lname' => 'lastname',
                'mobile' => '09283759482',
                'email' => 'secret@gmail.com',
                'password' => Hash::make('secret'),
                'address1' => 'Lorem Ipsum 12',
                'address2' => 'Lorem Ipsum 1432',
                'city' => 'valenzuela',
                'province' => 'metro manila',
            ],
            [
                'fname' => 'secret',
                'lname' => 'lastname',
                'mobile' => '09283759482',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'role' => 'admin',
                'address1' => 'Lorem Ipsum 12',
                'address2' => 'Lorem Ipsum 1432',
                'city' => 'pateros',
                'province' => 'metro manila',
            ]
        );
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
