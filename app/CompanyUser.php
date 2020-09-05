<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyUser extends Model
{
    /**
     * Field that are not mass assignment
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get company
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\Company');
    }
}
