<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->type == 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'fields' => 'required|array|min:1|max:5',
            'fields.*.key' => 'required|alpha_dash',
            'fields.*.is_required' => 'required'
        ];
    }

    /**
     * Customize validation messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'fields.required' => 'Fields is required',
            'fields.*.key.required' => 'Key should not be blank',
            'fields.*.key.alpha_dash' => 'Key may only contain letters, numbers, dashes, space is restricted',
        ];
    }
}
