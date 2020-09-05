<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactList extends Model
{
    const UNCATEGORIZED = 'Uncategorized';
    /**
     * Field that are mass assignment
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Contact List belongs to User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    /**
     * Contact list has many contacts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany('App\Contact');
    }
}
