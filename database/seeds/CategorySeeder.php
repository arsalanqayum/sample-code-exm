<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Category::truncate();

        DB::table('categories')->insert([
            [
                'name' => 'Guns',
                'slug' => 'guns',
                'status' => 'published'
            ]
        ]);

        DB::table('category_attributes')->insert([
            [
                'category_id' => 1,
                'key' => 'type',
                'is_required' => true,
            ],
            [
                'category_id' => 1,
                'key' => 'year',
                'is_required' => true,
            ]
        ]);
    }
}
