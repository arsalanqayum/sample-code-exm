<?php

namespace App;

use App\Traits\HasPhone;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Interfaces\WalletFloat;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Traits\HasWalletFloat;
use Illuminate\Database\Eloquent\Model;

class Company extends Model implements Wallet
{
    use HasPhone, HasWallet;
    /**
     * Field that are not mass assignment
     *
     * @var array
     */
    protected $guarded = [];


    /** @var array */
    protected $hidden = [
        'pivote'
    ];

    /** @var array */
    protected $appends = ['phone_number'];

    /**
     * Get Company Contact list
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contact_lists()
    {
        return $this->hasMany('App\ContactList');
    }

    /**
     * Get company contacts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany('App\Contact');
    }

    /**
     * Get company campaigns
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function campaigns()
    {
        return $this->hasMany('App\Campaign');
    }

    /**
     * Get company users
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\CompanyUser');
    }

    /**
     * Get all of the company's tags.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function tags()
    {
        return $this->morphMany('App\Tag', 'taggable');
    }

    /**
     * Get route key name of model routing
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
