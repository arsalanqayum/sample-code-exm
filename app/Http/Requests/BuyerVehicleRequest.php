<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuyerVehicleRequest extends FormRequest
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
            'make' => 'required|max:100',
            'model' => 'required|max:100',
            'year' => 'required|max:100',
            'language' => 'required|max:100',
        ];
    }
}
