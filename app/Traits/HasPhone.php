<?php

namespace App\Traits;

use Brick\PhoneNumber\PhoneNumber;

trait HasPhone
{
    /**
     * Get phone number attribute by combining dial code and phone
     *
     * @return string
     */
    public function getPhoneNumberAttribute()
    {
        return "+{$this->dial_code}{$this->phone}";
    }

    /**
     * Scope phone number
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param string $phone_number
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeOfPhone($query, $phone_number)
    {
        $number = PhoneNumber::parse($phone_number)->getNationalNumber();

        return $query->wherePhone($number);
    }
}