<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createMutipleUsers = [
            ['name' => 'superadmin', 'email' => 'superadmin@superadmin.com', 'password' => bcrypt('password'), 'mobile' => '1234567890', 'username' => 'superadmin'],
            ['name' => 'root', 'email' => 'root@root.com', 'password' => bcrypt('root'), 'mobile' => '6383273344', 'username' => 'root123'],
            ['name' => 'user', 'email' => 'user@user.com', 'password' => bcrypt('user'), 'mobile' => '3323432423', 'username' => 'user123'],
            ['name' => 'ram', 'email' => 'ram@ram.com', 'password' => bcrypt('ram'), 'mobile' => '3343434343', 'username' => 'ram123'],
            ['name' => 'max', 'email' => 'max@max.com', 'password' => bcrypt('max'), 'mobile' => '4343243243', 'username' => 'max123']
        ];

        DB::table('users')->insert($createMutipleUsers);
    }
}
