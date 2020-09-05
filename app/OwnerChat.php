<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OwnerChat extends Model
{
    const WAITING_FEEDBACK = 'waiting_feedback';

    const TERMINATED = 'terminated';

    const IN_PROGRESS = 'in_progress';

    /**
     * Field that are mass assignment
     *
     * @var array
     */
    protected $fillable = ['product_slug', 'type'];

    /**
     * Get buyer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function buyer()
    {
        return $this->belongsTo('App\Buyer');
    }

    /**
     * Get user/owner
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get owner chat messages
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany('App\OwnerChatMessage');
    }
}
