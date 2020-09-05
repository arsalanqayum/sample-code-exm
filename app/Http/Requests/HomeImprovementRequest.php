<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeImprovementRequest extends FormRequest
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
            'contact_person'=>'required',
            'manufacturer'=>'required',
            'product_type_id'=>"required",
            'type'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'baught_at.required' => 'The bought at field is required.',
           
        ];
    }
}
