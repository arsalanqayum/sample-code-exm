<?php

namespace App\Console\Commands;

use App\Campaign;
use App\Company;
use App\Events\PaymentTransfered;
use App\Transaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CampaignPayOwnerReward extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:pay_owner_reward';

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
        $campaigns = Campaign::whereStatus('completed')
            ->whereDate('end_date', '<=', now()->addDays(3))
            ->limit(100)
            ->get();

        //loop campaign and check if Campaign account/owner has unpaid earning
        foreach ($campaigns as $campaign) {
            $accounts = $campaign->accounts()->where('paid', false);
            $totalReward = $accounts->sum('earning');
            $company = Company::find($campaign->company_id);

            //If company balance is enough to pay owner, transfer balance to owner
            if($company && $company->balance >= $totalReward) {
                $this->payOwners($accounts->get(), $company, $totalReward);
            }
        }
    }

    /**
     * Pay owner
     *
     * @param \Illuminate\Database\Eloquent\Collection $accounts
     * @param Company $company
     * @param string|int $totalReward
     * @return void
     */
    private function payOwners($accounts, $company, $totalReward)
    {
        foreach ($accounts as $account) {
            $company->transfer($account->user, $totalReward, ['type' => Transaction::REWARD_PAY]);
            $account->paid = true;
            $account->save();

            event(new PaymentTransfered($account->user, $totalReward));
        }
    }
}
