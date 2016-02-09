<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Paul McGarry',
            'email' => 'mcgarryit@gmail.com',
            'password' => Hash::make('Secure2016Sponsor'),
            'registered' => 1,
            'updated_by' => 0,
        ]);
        DB::table('user_roles')->insert([
            'user_id' => 1,
            'role_type' => 'Administrator',
            'updated_by' => 1
        ]);
    }
}
