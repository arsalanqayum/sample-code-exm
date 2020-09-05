<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstantAlert extends Model
{
    const PENDING = 'pending';
    const COMPLETED = 'completed';

    /**
     * Field that are mass assignment
     *
     * @var array
     */
    protected $fillable = ['body', 'name', 'start_date', 'type'];

    /**
     * Get instant alert user, can be company or Super admin
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get all instant alert recipients
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipients()
    {
        return $this->hasMany('App\InstantAlertRecipient');
    }
}
