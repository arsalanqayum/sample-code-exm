<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'user_id' => 2,
                'category_id' => 1,
                'name' => 'Carbine 1947',
                'slug' => 'carbine-1947',
                'bought_at' => 'Amazon'
            ],
            [
                'user_id' => 3,
                'category_id' => 1,
                'name' => 'Carbine 1947',
                'slug' => 'carbine-1947',
                'bought_at' => 'Amazon'
            ],
        ]);

        DB::table('product_attribute_values')->insert([
            [
                'category_attribute_id' => 1,
                'value' => 'Carbine',
                'product_id' => 1,
            ],
            [
                'category_attribute_id' => 2,
                'value' => '1947',
                'product_id' => 1,
            ],
            [
                'category_attribute_id' => 1,
                'value' => 'Carbine',
                'product_id' => 2,
            ],
            [
                'category_attribute_id' => 1,
                'value' => '1947',
                'product_id' => 2,
            ]
        ]);
    }
}
