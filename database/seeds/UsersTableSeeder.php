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
        $users = [
            ['name' => 'McGarryit', 'role' => 'Administrator', 'projectId' => 0],

            ['name' => 'Coord One', 'role' => 'Coordinator', 'projectId' => 1],
            ['name' => 'Recp One', 'role' => 'Recipient', 'projectId' => 1],
            ['name' => 'Recp Two', 'role' => 'Recipient', 'projectId' => 1],
            ['name' => 'Recp Three', 'role' => 'Recipient', 'projectId' => 1],
            ['name' => 'Recp Four', 'role' => 'Recipient', 'projectId' => 1],
            ['name' => 'Spon One', 'role' => 'Sponsor', 'projectId' => 1],
            ['name' => 'Spon Two', 'role' => 'Sponsor', 'projectId' => 1],
            ['name' => 'Spon Three', 'role' => 'Sponsor', 'projectId' => 1],
            ['name' => 'Spon Four', 'role' => 'Sponsor', 'projectId' => 1],

            ['name' => 'Coord A', 'role' => 'Coordinator', 'projectId' => 2],
            ['name' => 'Recp A', 'role' => 'Recipient', 'projectId' => 2],
            ['name' => 'Recp B', 'role' => 'Recipient', 'projectId' => 2],
            ['name' => 'Recp C', 'role' => 'Recipient', 'projectId' => 2],
            ['name' => 'Recp D', 'role' => 'Recipient', 'projectId' => 2],
            ['name' => 'Spon A', 'role' => 'Sponsor', 'projectId' => 2],
            ['name' => 'Spon B', 'role' => 'Sponsor', 'projectId' => 2],
            ['name' => 'Spon C', 'role' => 'Sponsor', 'projectId' => 2],
            ['name' => 'Spon D', 'role' => 'Sponsor', 'projectId' => 2],
        ];

        foreach ($users as $userRow) {
            $this->addUser($userRow);
        }
    }

    public function addUser($userRow) {
        DB::table('users')->insert([
            'name' => $userRow['name'],
            'email' => strtolower(str_replace(" ", "", $userRow['name'])."@gmail.com"),
            'skrill_acc' => strtolower(str_replace(" ", "", $userRow['name'])."@gmail.com"),
            'password' => Hash::make('Secure2016Sponsor'),
            'registered' => 1,
            'updated_by' => 0,
        ]);
        $userID = DB::getPdo()->lastInsertId();

        DB::table('user_roles')->insert([
            'user_id' => $userID,
            'role_type' => $userRow['role'],
            'updated_by' => 1
        ]);

    }
}
