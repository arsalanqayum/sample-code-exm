<?php

namespace App;

use App\Filters\UserFilter;
use App\Traits\HasPhone;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Interfaces\WalletFloat;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Traits\HasWalletFloat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements Wallet
{
    use Notifiable, HasApiTokens, HasPhone, HasWallet;

    const COMPANY = 'company';

    const OWNER = 'owner';

    const ACTIVATED = 'active';

    const AVAILABLE = 'available';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'phone', 'email', 'password',
    ];
    // protected $hidden = ['pivot'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','pivot'
    ];

    /**
     * The accessors to append to the model's array form
     *
     * @var array
     */
    protected $appends = ['full_name', 'phone_number'];

    /**
     * User has many company
     */
    public function companyUser()
    {
        return $this->hasOne('App\CompanyUser');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Get companies owned by user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companies()
    {
        return $this->hasMany('App\Company');
    }

    /**
     * Get all ratings own by user, the user type should be owner
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratings()
    {
        return $this->hasMany('App\OwnerRating');
    }

    /**
     * Get user products
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany('App\Product');
    }

    /**
     * Get user profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne('App\UserProfile');
    }

    /**
     * Get the user's verification
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function verification()
    {
        return $this->morphOne('App\Verification', 'verificable');
    }

    /**
     * Get user that own company
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function company()
    {
        return $this->hasOne('App\Company');
    }

    /**
     * Get user reward
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function reward()
    {
        return $this->hasOne('App\Reward');
    }

    /**
     * Get user stripe account
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function stripeAccount()
    {
        return $this->hasOne('App\StripeAccount');
    }

    /**
     * Get user campaign account
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign_account()
    {
        return $this->belongsTo('App\CampaignAccount');
    }

    /**
     * Get all of the user's payment histories.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function paymentHistories()
    {
        return $this->morphMany('App\PaymentHistory', 'payment_historiable');
    }

    /**
     * Get user's fullname
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Verify user
     *
     * @param boolean $bool
     * @return void
     */
    public function verify($bool)
    {
        $this->forceFill([
            'is_verified' => $bool
        ])->save();
    }

    /**
     * Add scope filter
     *
     * @param Builder $query
     * @param UserFilter $userFilter
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter(Builder $query, UserFilter $userFilter)
    {
        return $userFilter->apply($query);
    }

    /**
     * Check if user is admin
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->type == 'admin';
    }

    /**
     * Check if user is company
     *
     * @return bool
     */
    public function isCompany()
    {
        return $this->type == 'company';
    }

    /**
     * Get user's chats
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chats()
    {
        return $this->hasMany('App\OwnerChat');
    }
}
