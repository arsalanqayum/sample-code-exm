<?php

namespace App\Http\Requests\Owner;

use App\CategoryAttribute;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->type == 'owner' || auth()->user()->type == 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $categoryAttributes = CategoryAttribute::where('category_id', request('category_id'))->get(['key', 'is_required']);

        $rules = collect(
            [
                'bought_at' => "required",
                'category_id' => 'required',
            ]
        );

        if(count($categoryAttributes)) {
            foreach ($categoryAttributes as $attr) {
                $rules->put($attr->key, $attr->is_required ? 'required' : 'nullable');
            }
        }

        return $rules->toArray();
    }

    /**
     * Customize validation messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'category_id.required' => "The category field is required",
        ];
    }
}
