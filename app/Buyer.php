<?php

namespace App;

use App\Traits\HasPhone;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    use HasPhone;
    /**
     * Field that are not mass assignment
     *
     * @var array
     */
    protected $guarded = ['is_verified'];

    /** @var array */
    protected $appends = ['phone_number'];

    /**
     * Get the buyer's verification
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function verification()
    {
        return $this->morphOne('App\Verification', 'verificable');
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
}
