<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstantAlertRecipient extends Model
{
    const PENDING = 'pending';
    const SENT = 'sent';
    const FAILED = 'failed';

    /**
     * Field that are mass assignment
     *
     * @var array
     */
    protected $fillable = ['contact_id'];

    /**
     * Set recipient status by given param
     *
     * @param string $status
     * @return bool
     */
    public function changeStatus($status)
    {
        return $this->forceFill([
            'status' => $status
        ])->save();
    }

    /**
     * Get instant alert
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function instant_alert()
    {
        return $this->belongsTo('App\InstantAlert');
    }

    /**
     * Get contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo('App\Contact');
    }
}
