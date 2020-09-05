<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryAttribute extends Model
{
    /**
     * Field that are not mass assignment
     *
     * @var array
     */
    protected $guarded = ['category_id'];

    /**
     * Get category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    /**
     * Get product attribute value
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function values()
    {
        return $this->hasMany('App\ProductAttributeValue');
    }
}
