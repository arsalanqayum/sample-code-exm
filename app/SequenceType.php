<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SequenceType extends Model
{
    /**
     * Field that are mass assignment
     *
     * @var array
     */
    protected $guarded = ['prebuilt_start_day_after'];

    /**
     * The attributes that should be mutated to dates
     *
     * @var array
     */
    protected $casts = ['start_date'];

    /**
     * Get Sequence Type Campaign
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo('App\Campaign');
    }

    /**
     * Get sequence Type template
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function template()
    {
        return $this->belongsTo('App\Template');
    }

    /**
     * Get Sequence Type Contact List
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact_list()
    {
        return $this->belongsTo('App\ContactList');
    }

    /**
     * Get st recipient statuses
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipients()
    {
        return $this->hasMany('App\RecipientStatus');
    }
}
