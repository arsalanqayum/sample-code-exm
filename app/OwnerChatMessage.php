<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OwnerChatMessage extends Model
{
    /**
     * Field that are mass assignment
     *
     * @var array
     */
    protected $fillable = ['body'];

    /**
     * Get owner chat room
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ownerChat()
    {
        return $this->belongsTo('App\OwnerChat');
    }
}
