<?php

namespace App\Console\Commands;

use App\Contact;
use Illuminate\Console\Command;

class PatternTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pattern:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $body = "Hello {fiarst_name} {last_name}";
        $contact = Contact::find(1);

        $pattern = "/\{([^}]+)\}/";

        preg_match_all($pattern, $body, $placeholders);

        $placeholders = $placeholders[1];

        for ($i= 0; $i < count($placeholders) ; $i++) {
            if($contact[$placeholders[$i]]) {
                $body = preg_replace("/{{$placeholders[$i]}}/", $contact[$placeholders[$i]], $body);
            }
        }

        dd($body);
    }
}
