<?php

namespace App;

use App\Filters\ProductFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    const BASIC_COLUMN = ['bought_at', 'state', 'city', 'category_id', 'name'];

    const REJECTED = 'rejected';
    const ACCEPTED = 'accepted';
    const BEING_VERIFIED = 'being_verified';

    protected $guarded = ['user_id'];

    /**
     * Append accessor to json
     *
     * @var array
     */
    protected $appends = ['from'];

    /**
     * Get product attribute values
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attr_values()
    {
        return $this->hasMany('App\ProductAttributeValue');
    }

    /**
     * Get product category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    /**
     * Get product user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * If bought at is company and has registered, return company name
     *
     * @return string
     */
    public function getFromAttribute()
    {
        $bought_at = $this->bought_at;

        $company = Company::where('id', $bought_at)->first();

        if($company) {
            return $company->name;
        }

        return $bought_at;
    }

    /**
     * Scope filter
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param ProductFilter $productFilter
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter(Builder $query, ProductFilter $productFilter)
    {
        return $productFilter->apply($query);
    }
}
