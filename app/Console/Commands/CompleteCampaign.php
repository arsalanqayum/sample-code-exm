<?php

namespace App\Console\Commands;

use App\Campaign;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CompleteCampaign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:complete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark all campaign status inside database as completed';

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
     * @return int
     */
    public function handle()
    {
        Campaign::unguard();
        Campaign::whereDate('end_date', '<=', now())->update([
            'status' => Campaign::COMPLETED
        ]);
        Campaign::reguard();
    }
}
