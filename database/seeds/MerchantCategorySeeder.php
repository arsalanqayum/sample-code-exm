<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MerchantCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('merchant_categories')->insert([
            [
                'name' => 'Book Stores',
                'slug' => 'book_stores',
                'code' => '5942'
            ],
            [
                'name' => 'Computer Software Stores',
                'slug' => 'computer_software_stores',
                'code' => '5734'
            ]
        ]);
    }
}
