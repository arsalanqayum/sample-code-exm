<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    // Status
    const ACTIVE = 'active';
    const DRAFT = 'draft';
    const COMPLETED = 'completed';

    // Chat Purpose
    const SALES = 'sales';
    const SUPPORT = 'support';

    /**
     * Field that are not mass assignment
     *
     * @var array
     */
    protected $guarded = ['status'];

    /**
     * The attributes tat should be mutated to dates
     *
     * @var array
     */
    protected $dates = ['end_date'];

    /**
     * Get campaign sequence types
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sequence_types()
    {
        return $this->hasMany('App\SequenceType');
    }

    /**
     * Get campaign company
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    /**
     * Get all contacts or contacts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany('App\Contact');
    }

    /**
     * Get all campaign's accounts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts()
    {
        return $this->hasMany('App\CampaignAccount');
    }

    /**
     * Create data values for sequences
     *
     * @return array
     */
    public function sequenceData()
    {
        $data = $this->sequence_types->map( function($st) {
            return [
                'status' => 'pending',
                'st_id' => $st->id,
                'template' => $st->template->name
            ];
        });

        return $data;
    }

    /**
     * Check if company can pay owners
     *
     * @return boolean
     */
    public function canPayOwners()
    {
        return $this->company->balance < $this->accounts()->sum('earning') ? false : true;
    }

    /**
     * Check if company has pay all owner inside the campaign
     *
     * @return boolean
     */
    public function hasPayOwners()
    {
        return $this->accounts()->where('paid', false)->exists() ? false : true;
    }
}
