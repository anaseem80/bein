<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('users')->insert([
            'role'=>'owner',
            'first_name'=>'Ahmed',
            'last_name'=>'Yahia',
            'name'=>'Ahmed Yahia',
            'email'=>'mr.ahmed.yahia.t2@gmail.com',
            'password'=>Hash::make('12345678'),
            'email_verified_at'=>'2021-12-18 17:00:00'
        ]);

    }
}
