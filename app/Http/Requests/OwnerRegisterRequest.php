<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OwnerRegisterRequest extends FormRequest
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
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required|min:6',
            'gender' => 'required',
            'age_range' => 'required',
            'communication_type' => 'required',
            'timezone' => 'required',
            'languages' => 'required',
            'time_to_chats' => 'required',
            'zip_code' => 'required',
            'address' => 'required',
        ];
    }
}
