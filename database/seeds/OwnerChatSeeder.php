<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OwnerChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('owner_chats')->insert([
            [
                'user_id' => 2,
                'buyer_id' => 1,
                'product_slug' => 'carbine-1947',
                'type' => 'video'
            ],
            [
                'user_id' => 3,
                'buyer_id' => 1,
                'product_slug' => 'carbine-1947',
                'type' => 'video'
            ]
        ]);
    }
}
