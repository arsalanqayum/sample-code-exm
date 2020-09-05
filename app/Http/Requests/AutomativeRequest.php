<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AutomativeRequest extends FormRequest
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
            'baught_at'=>'required',
            'state'=>'required',
            'city'=>'required',
            'make'=>'required',
            'model'=>'required',
            'year'=>'required',
            'product_type_id'=>'required',
        ];
    }
}
