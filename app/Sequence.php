<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sequence extends Model
{

    const FAILED = 'failed';
    const SENT = 'sent';

    /**
     * field that are mass assignment
     *
     * @var array
     */
    protected $fillable = ['contact_id', 'data'];

    /**
     * Set sequence status by given param
     *
     * @param int $st_id
     * @param string $status
     * @return bool
     */
    public function changeStatus($st_id, $status)
    {
        $data = collect(json_decode($this->data, true))->map( function($st) use($st_id, $status) {
            if($st['st_id'] == $st_id) {
                $st['status'] = $status;
            }

            return $st;
        });

        return $this->forceFill([
            'data' => $data
        ])->save();
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

    /**
     * Get campaign
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo('App\Campaign');
    }

    /**
     * Get sequence type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sequence_type()
    {
        return $this->belongsTo('App\SequenceType');
    }
}
