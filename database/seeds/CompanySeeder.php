<?php

use App\Company;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name' => 'Company',
            'last_name' => 'Sample',
            'phone' => '23456',
            'email' => 'company@gmail.com',
            'password' => Hash::make('password'),
            'type' => User::COMPANY,
            'status' => User::ACTIVATED,
            'photo' => 'profile.png',
            'chat_status' => User::AVAILABLE,
            'is_verified' => true,
        ]);

        $company = Company::create([
            'user_id' => $user->id,
            'name' => 'OwnerChat',
            'slug' => 'ownerchat',
            'phone' => '8888675309',
            'city' => 'Schenectady',
            'state' => 'NY',
            'logo' => 'no',
            'country' => 'USA',
            'street_address' => '123 State st',
            'zip' => '12345',
            'expiry_date' => now()->addYear(1),
        ]);

        $company->contact_lists()->create(['name' => 'Uncategorized']);
    }
}
