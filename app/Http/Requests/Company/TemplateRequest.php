<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class TemplateRequest extends FormRequest
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
            'name' => 'required',
            'body' => 'required',
            'type' => 'required',
            'subject' => 'required_if:type,email',
            'attachment' => 'nullable',
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
            'subject.required_if' => 'The subject field is required'
        ];
    }
}
