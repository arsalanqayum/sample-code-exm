<?php

namespace App\Http\Requests\Stripe;

use Illuminate\Foundation\Http\FormRequest;

class StorePerson extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'dob' => 'required',
            'ssn' => 'required',
            'address' => 'required',
        ];
    }

    /**
     * Customize validation messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'dob.required' => 'The date of birth is required',
        ];
    }
}
