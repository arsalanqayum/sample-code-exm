<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\phoneNumberValidation;

class CompanyRequest extends FormRequest
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
            'name'=>'required',
            'phone' => ['required','unique:companies'],
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'expiry_date'=> 'required',
            'street_address' => 'required',
            'zip' => 'nullable|max:5',
            'product_type' => 'required',
        ];
    }
}
