<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->type == 'admin' || auth()->user()->type == 'company';
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
            'phone' => 'required|max:15',
            'email' => 'required|email:rfc',
            'other' => 'nullable',
            'contact_list_id' => 'nullable',
        ];
    }
}
