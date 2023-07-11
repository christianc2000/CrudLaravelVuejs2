<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name" => "christian",
            "email" => "christian@gmail.com",
            "password" => bcrypt("12345678")
        ]);
        User::create([
            "name" => "user1",
            "email" => "user1@gmail.com",
            "password" => bcrypt("12345678")
        ]);
        User::create([
            "name" => "user2",
            "email" => "user2@gmail.com",
            "password" => bcrypt("12345678")
        ]);
        User::create([
            "name" => "user3",
            "email" => "user3@gmail.com",
            "password" => bcrypt("12345678")
        ]);
    }
}
