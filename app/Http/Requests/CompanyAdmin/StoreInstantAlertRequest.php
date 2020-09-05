<?php

namespace App\Http\Requests\CompanyAdmin;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstantAlertRequest extends FormRequest
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
            'start_date' => 'required',
        ];
    }
}
