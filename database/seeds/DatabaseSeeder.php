<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            StateSeeder::class,
            OwnerSeeder::class,
            CompanySeeder::class,
            ProductSeeder::class,
            OwnerChatSeeder::class,
            TemplateSeeder::class,
            CampaignTemplateSeeder::class,
            MerchantCategorySeeder::class,
        ]);
    }
}
