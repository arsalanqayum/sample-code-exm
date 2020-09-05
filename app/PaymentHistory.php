<?php

namespace App;

use App\Traits\AmountConverter;
use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    use AmountConverter;
    /** Status Contant */
    const CHARGE = 'charge';
    const TRANSFER = 'transfer';
    const PAYOUT = 'payout';


    /** @var array */
    protected $guarded = [];

    /**
     * Get the owner historiable model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function historiable()
    {
        return $this->morphTo();
    }
}
