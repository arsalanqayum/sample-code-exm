<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Owner that already connected with campaign
 */
class CampaignAccount extends Model
{
    const PENDING = 'pending';
    const ACTIVE = 'active';

    /**
     * Get account's owner
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get account's campaign
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo('App\Campaign');
    }
}
