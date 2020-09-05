<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstantAlert extends FormRequest
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
            'contact_list_id' => 'required_if:import_by,contact_list',
            'tags' => 'array|required_if:import_by,tags',
            'import_by' => 'required|in:contact_list,tags'
        ];
    }

    /**
     * Customeize rules messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            '*.required_if' => 'The :attribute field is required'
        ];
    }

    /**
     * Custome attributes
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'contact_list_id' => 'contact list'
        ];
    }
}
