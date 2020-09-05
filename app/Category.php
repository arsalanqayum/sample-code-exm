<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Field that are not mass assignment
     *
     * @var array
     */
    protected $guarded = ['category_id'];

    /**
     * Get the route key for the model
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get category attributes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attrs()
    {
        return $this->hasMany('App\CategoryAttribute');
    }

    /**
     * Get category products
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
