<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'fname' => 'secret',
            'lname' => 'lastname',
            'mobile' => '19283759482',
            'email' => 'secret@gmail.com',
            'password' => Hash::make('secret'),
            'address1' => 'Lorem Ipsum 12',
            'address2' => 'Lorem Ipsum 1432',
            'city' => 1,
            'province' => 'pangasinan cavite',
        ]);
    }
}
