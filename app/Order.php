<?php

namespace App;

use App\Traits\AmountConverter;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use AmountConverter;

    const ACCEPTED = 'accepted';
    const REJECTED = 'rejected';

    /** @var array */
    protected $guarded = [];

    /**
     * User that make order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Company that need to approved or dissaproved order
     * if null, it will related to super admin
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\Company');
    }
}
