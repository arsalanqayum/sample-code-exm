<?php

namespace App\Console\Commands;

use App\Events\PaymentTransfered;
use Bavix\Wallet\Models\Wallet;
use Illuminate\Console\Command;

class CheckPendingBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'balance:send_pending_balance';

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
     * @return int
     */
    public function handle()
    {
        $wallets = Wallet::where('holder_type', 'App\User')->where('balance', '!=', 0)->get();

        if(count($wallets)) {
            foreach ($wallets as $wallet) {
                event(new PaymentTransfered($wallet->holder, $wallet->holder->balance));
            }
        }
    }
}
