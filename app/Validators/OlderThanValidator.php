<?php

namespace App\Validators;

use DateTime;

class OlderThanValidator
{
    /**
     * Validate rules
     *
     * @param mixed $attribute
     * @param mixed $value
     * @param mixed $parameters
     */
    public function validate($attribute, $value, $parameters)
    {
        $minAge = ( ! empty($parameters)) ? (int) $parameters[0] : 13;
        return (new DateTime)->diff(new DateTime($value))->y >= $minAge;
    }
}