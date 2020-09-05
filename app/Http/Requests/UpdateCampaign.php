<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCampaign extends FormRequest
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
            'name' => 'required_if:step,campaign',
            'step' => [
                'required',
                Rule::in(['campaign', 'sequence-type', 'recipient']),
            ],
            'type' => 'required|in:email,sms',
            'chat_purpose' => 'required|in:sales,support',
            'reward_value' => 'required|numeric|between:0.5,10.00',
            'end_date' => 'required|date|after:+1 day',
        ];
    }
}
