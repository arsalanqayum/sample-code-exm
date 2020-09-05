<?php

use App\Template;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('templates')->insert([
            [
                'name' => 'How it works',
                'subject' => 'How it works',
                'body' => "This is how it works email",
                'type' => Template::EMAIL,
                'public' => true,
            ],
            [
                'name' => 'Last request',
                'subject' => 'Last request',
                'body' => "
                    <p>
                        What is your Last request?
                    </p>
                ",
                'type' => Template::EMAIL,
                'public' => true,
            ],
            [
                'name' => 'Top questions',
                'subject' => 'top questions',
                'body' => "This is the top questions email template",
                'type' => Template::EMAIL,
                'public' => true,
            ],

            [
                'name' => 'Register Invitation',
                'subject' => null,
                'body' => "You have been invited to register the {company_name} company on OwnerChat.
                To get started, here the sign up link {url}",
                'type' => Template::SMS,
                'public' => true,
            ],
            [
                'name' => 'How much you can earn',
                'subject' => 'How much you can earn',
                'body' => "How much you can earn from ownerchat? we dont know.",
                'type' => Template::EMAIL,
                'public' => true,
            ],
        ]);
    }
}
