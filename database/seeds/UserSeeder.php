<?php

use App\User;
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
        App\User::truncate();
        \Illuminate\Support\Facades\DB::table('users')->insert([
            [
                'first_name' => 'Arsalan',
                'last_name' => 'Qayoom',
                'phone' => '2345',
                'status' => User::ACTIVATED,
                'type' => 'admin',
                'photo' => 'profile.png',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('password'),
                'is_verified' => true,
            ]

        ]);
    }
}
