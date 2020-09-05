<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Reward extends Model
{
    /**
     * Field that are mass assignment
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * Exchange available_points to completed_redeem or vice versa
     *
     * @param string $destination
     * @param int $point
     * @return bool
     */
    public function exchange($destination, $point)
    {
        $exchangeFrom = $destination == 'available_points' ? 'completed_redeem': 'available_points';

        $this->forceFill([
            $destination => $this->{$destination} + $point,
            $exchangeFrom => $this->{$exchangeFrom} - $point,
        ])->save();
    }
}
