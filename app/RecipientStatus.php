<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Campaign recipient status
 */
class RecipientStatus extends Model
{
    const FAILED = 'failed';

    /** @var array */
    protected $fillable = ['contact_id'];

    /**
     * Get sequence type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sequence_type()
    {
        return $this->belongsTo('App\SequenceType');
    }

    /**
     * Get recipient contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo('App\Contact');
    }
}
