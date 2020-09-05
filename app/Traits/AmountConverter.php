<?php

namespace App\Traits;

/**
 * This trait should only use in model only.
 */
trait AmountConverter
{
    /**
     * Divide amount by 100 if currency is usd
     *
     * @param int $value
     * @return int
     */
    public function getAmountAttribute($value)
    {
        return $value / 100;
    }
}