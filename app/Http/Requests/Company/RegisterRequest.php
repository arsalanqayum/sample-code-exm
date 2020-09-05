<?php

namespace App\Http\Requests\Company;

use App\Rules\phoneNumberValidation;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
            // Company
            'name'=>'required',
            'phone' => 'required|unique:users',
            // 'city' => 'nullable',
            'state' => 'nullable',
            'country' => 'required',
            'street_address' => 'nullable',
            'zip' => 'nullable|max:5',
        ];
    }
}
