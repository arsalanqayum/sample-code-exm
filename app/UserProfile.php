<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    const SEARCH_FIELDS = ['sex', 'age', 'lat', 'lng'];

    protected $guarded = [];
}
