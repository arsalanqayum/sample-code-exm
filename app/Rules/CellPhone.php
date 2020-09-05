<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CellPhone implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $cell_phone;
    public function __construct($cell_phone)
    {
        $this->cell_phone = $cell_phone;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //dd($value);
        return  preg_match('%^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$%i', $value) && strlen($value) >= 10;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be valid.';
    }
}
