<?php

use App\Product;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name' => 'Owner',
            'last_name' => 'Seeder',
            'phone' => '6412006820',
            'email' => 'owner@gmail.com',
            'password' => Hash::make('password'),
            'type' => User::OWNER,
            'status' => User::ACTIVATED,
            'photo' => 'profile.png',
            'chat_status' => User::AVAILABLE,
            'is_verified' => true,
        ]);

        $user2 = User::create([
            'first_name' => 'Owner',
            'last_name' => 'Seeder',
            'phone' => '6412006151',
            'email' => 'owner2@gmail.com',
            'password' => Hash::make('password'),
            'type' => User::OWNER,
            'status' => User::ACTIVATED,
            'photo' => 'profile.png',
            'chat_status' => User::AVAILABLE,
            'is_verified' => true,
        ]);

        DB::table('user_profiles')->insert([
            'user_id' => 2,
            'age_range' => '18-24',
            'city' => 'Brooklyn',
            'state' => 'New York',
            'gender' => 'male',
            'language' => 'english',
            'time_to_chat' => 'morning',
            'communication_type' => 'sms-and-video',
            'timezone' => 'Eastern Standard Time',
            'zip_code' => '11212',
            'address' => 'Brooklyn, NY 11212, USA'
        ]);

        DB::table('user_profiles')->insert([
            'user_id' => 3,
            'age_range' => '18-24',
            'city' => 'Brooklyn',
            'state' => 'New York',
            'gender' => 'female',
            'language' => 'english',
            'time_to_chat' => 'morning',
            'communication_type' => 'sms',
            'timezone' => 'Eastern Standard Time',
            'zip_code' => '11212',
            'address' => 'Brooklyn, NY 11212, USA'
        ]);
    }
}
