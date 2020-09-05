<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class StoreCampaignRequest extends FormRequest
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
            'type' => 'required|in:email,sms',
            'chat_purpose' => 'required|in:sales,support',
            'reward_value' => 'required|numeric|between:0.5,10.00',
            'end_date' => 'required|date|after:+1 day',
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
            'reward_value.required' => 'The reward is required.'
        ];
    }
}
