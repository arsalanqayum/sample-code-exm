<?php

namespace App\Console\Commands;

use App\Contact;
use App\Facades\Twilio;
use App\Notifications\Company\SMSCampaign;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class TestSMS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:sms';

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
        $one = '+17028257755';
        $two = '+16412006151';
        $three = '+16412006820';
        $four = '+19014668475';
        // Twilio::sendSMS($one,null, $three, 'https://c1.staticflickr.com/3/2899/14341091933_1e92e62d12_b.jpg');
        // Twilio::sendSMS($four,'Hello Visitor', $three);
        // Twilio::sendSMS($four,null, $two, 'https://c1.staticflickr.com/3/2899/14341091933_1e92e62d12_b.jpg');
        // Twilio::sendSMS($four, 'yes', $two);
        Twilio::sendSMS($four, 'Hello Visitor', $three);
    }
}
