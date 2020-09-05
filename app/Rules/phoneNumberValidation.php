<?php

namespace App\Rules;

use App\User;
use Illuminate\Contracts\Validation\Rule;

class phoneNumberValidation implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        //dd($value,$attribute);
         $user=User::where('cell_phone',$value)->first();
        if($user){
            return false;
        }else{
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The phone number has already been taken.';
    }
}
