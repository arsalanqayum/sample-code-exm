<?php

namespace App;

use Bavix\Wallet\Models\Transaction as BavixTransaction;

class Transaction extends BavixTransaction
{
    const CHARGE = 'charge';
    const TRANSFER = 'transfer';
    const PAYOUT = 'payout';
    const TOP_UP = 'top_up';
    const REWARD_PAY = 'reward_pay';
}
