<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeValue extends Model
{
    /**
     * Field that are not mass assignment
     *
     * @var array
     */
    protected $guarded = ['product_id'];
}
