<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserDemographics extends FormRequest
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
            'sex'=>'required',
            'age'=>'required',
            'location'=>'required',
            'state'=>'required',

            'city'=>'required',
            'lng'=>'required',
            'lat'=>'required',
            'address'=>'required'
        ];
    }
}
