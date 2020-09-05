<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ImplicitRule;

class PhoneNumber implements ImplicitRule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //Check if value contain + in the start
        if(substr($value, 0 ,1) == '+') {
            $noPlus = str_replace('+','', $value);

            return is_numeric($noPlus);
        }

        return is_numeric($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid phone number format.';
    }
}
