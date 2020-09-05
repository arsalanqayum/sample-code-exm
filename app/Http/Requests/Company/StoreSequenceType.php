<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class StoreSequenceType extends FormRequest
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
            'multiple' => 'required|boolean',
            'sequence_types' => 'required_if:multiple,1|array',
            'start_date' => 'required_if:multiple,0|date',
            'template_id' => 'required_if:multiple,0',
        ];
    }

    /**
     * Customize validation message
     *
     * @return array
     */
    public function messages()
    {
        return [
            'template_id.required_if' => 'The template is required',
            'start_date.required_If' => 'The start date is required',
            'sequence_types' => 'The sequence type is required'
        ];
    }
}
