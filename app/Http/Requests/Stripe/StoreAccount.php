<?php

namespace App\Http\Requests\Stripe;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccount extends FormRequest
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
            'email' => 'nullable',
            'line1' => 'required',
            'line2' => 'nullable',
            'city' => 'required',
            'state' => 'required',
            'postal_code' => 'required',
            'phone' => 'required',
            'ssn' => 'required',
            'dob' => 'required|older_than',
            // 'gender' => 'required',
        ];
    }
}
