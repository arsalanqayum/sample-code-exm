<?php

namespace App\Listeners;

use App\CampaignAccount;
use App\OwnerChat;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class AddEarningToOwner
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param OwnerChat $ownerChat
     * @return void
     */
    public function handle(OwnerChat $ownerChat)
    {
        $user = $ownerChat->user;

        $accounts = CampaignAccount::where('user_id', $user->id)->where('status', CampaignAccount::ACTIVE)->get();

        foreach ($accounts as $account) {
            $account->increment('earning', $account->campaign->reward_value);
        }
    }
}
