<?php

namespace App\Http\Requests\Company;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class ImportContact extends FormRequest
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
            'type' => 'nullable',
            'tags' => 'nullable',
            'contacts' => 'required|array',
            'contacts.*.email' => 'email|required_if:type,email',
            'contacts.*.phone' => ['required_if:type,sms']
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
            'contacts.array' => 'Invalid contact format.',
            'contacts.*.email.required_if' => 'The email is required.',
            'contacts.*.email.email' => 'The email should be an email.',
            'contacts.*.phone.required_if' => 'The phone number is required.'
        ];
    }
}
