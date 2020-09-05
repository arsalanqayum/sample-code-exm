<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OwnerRating extends Model
{
    /**
     * Field that are mass assignment
     */
    protected $fillable = ['rating'];

    /**
     * Get owner from user model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
