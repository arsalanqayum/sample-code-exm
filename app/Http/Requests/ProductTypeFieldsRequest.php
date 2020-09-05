<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductTypeFieldsRequest extends FormRequest
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
            'product_type_id' => 'required|numeric',
            'title' => 'required|max:50',
            'type' => 'required|max:10',
            'field_level' => 'required|max:10',
            'visibility' => 'required|max:3',
            'use_for_title_generation' => 'required|max:3',
            'order' => 'required|numeric',
        ];
    }
}
