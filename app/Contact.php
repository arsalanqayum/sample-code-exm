<?php

namespace App;

use App\Traits\HasPhone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Contact extends Model
{
    use Notifiable, HasPhone;

    /** Status Field Enum */
    const CONTACT = 'contact';
    const CAMPAIGN = 'campaign';
    const OWNER = 'owner';

    /**
     * Field that are not mass assignment
     *
     * @var array
     */
    protected $guarded = [];

    /** @var array */
    protected $appends = ['phone_number', 'total_chats', 'earned'];

    /**
     * Contact belongs to contact list
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact_list()
    {
        return $this->belongsTo('App\ContactList');
    }

    /**
     * Contact belongs to company
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    /**
     * get all of the contact's taggable
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function tags()
    {
        return $this->morphToMany('App\Tag','taggable');
    }

    /**
     * Get contact campaign
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo('App\Campaign');
    }

    /**
     * Get contact recipient statuses
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipient_statuses()
    {
        return $this->hasMany('App\RecipientStatus');
    }

    /**
     * Add scope filter
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \App\Filters\ContactFilter $contactFilter
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $contactFilter)
    {
        return $contactFilter->apply($query);
    }

    /**
     * Attach contact to campaign
     *
     * @param int $campaign_id
     * @return boolean
     */
    public function attachCampaign($campaign_id)
    {
        return $this->forceFill([
            'campaign_id' => $campaign_id,
            'status' => $this::CAMPAIGN,
        ])->save();
    }

    /**
     * Detach contact from campaign
     *
     * @param string $status
     * @return boolean
     */
    public function detachCampaign($status = 'contact')
    {
        return $this->forceFill([
            'campaign_id' => null,
            'status' => $status
        ])->save();
    }

    /**
     * Change status of recipient
     *
     * @param int $st_id
     * @return boolean
     */
    public function changeStatus($st_id, $status = 'sent')
    {
        return $this->recipient_statuses()->where('sequence_type_id', $st_id)
        ->first()
        ->forceFill([
            'status' => $status
        ])->save();
    }

    /**
     * Get contact's user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get contact's total chat attributes
     *
     * @return int
     */
    public function getTotalChatsAttribute()
    {
        if($this->user && $this->user->chats()->exists()) {
            return count($this->user->chats);
        }

        return 0;
    }

    /**
     * Get contact's earned attributes
     *
     * @return int|float|mixed
     */
    public function getEarnedAttribute()
    {
        if($this->user) {
            return $this->user->balance;
        }

        return 0;
    }
}
