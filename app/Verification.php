<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    /**
     * Field that are not mass assignment
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * Update verification
     *
     * @return void
     */
    public function updateVerification()
    {
        $this->forceFill([
            'code' => null,
        ])->save();
    }

    /**
     * Get the owning verificable model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function verificable()
    {
        return $this->morphTo();
    }
}
