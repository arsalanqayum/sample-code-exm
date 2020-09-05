<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
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
        // dd('yes');

        $rule=[

            'address'=>'required',
            'lat'=>'required',
            'lng'=>'required',
            'distance'=>'required',
            'age'=>'required',
            'gender'=>'required'
        ];
        // $this->request->get('table_name'));
        if ($this->request->get('table_name') == 'product_automotive') {
            $automative=[
                'make'=>'required',
                'model'=>'required',
                "year"=>'required'
            ];
           $rule= array_merge($automative,$rule);
        }
        if ($this->request->get('table_name') == 'product_healthcare') {
            $automative=[
                'procedure'=>'required',
                'businessType'=>'required',
             
            ];
           $rule= array_merge($automative,$rule);
        }
        if ($this->request->get('table_name') == 'product_homes_realestate') {
            $automative=[
                'property_type'=>'required',
               
            ];
           $rule= array_merge($automative,$rule);
        }
        if ($this->request->get('table_name') == 'product_local_business') {
            $automative=[
                'service'=>'required',
             
            ];
           $rule= array_merge($automative,$rule);
        }
        if ($this->request->get('table_name') == 'product_fitness') {
            $automative=[
                'type'=>'required',
                'trainer'=>'required',
                
            ];
           $rule= array_merge($automative,$rule);
        }
        if ($this->request->get('table_name') == 'product_computers_electronics') {
            $automative=[
                'make'=>'required',
                'model'=>'required',
                "type"=>'required'
            ];
           $rule= array_merge($automative,$rule);
        }
        if ($this->request->get('table_name') == 'product_kids') {
            $automative=[
                'type'=>'required',
                'product_age'=>'required',
             
            ];
           $rule= array_merge($automative,$rule);
        }
        if ($this->request->get('table_name') == 'product_insurance_finance') {
            $automative=[
                'advisor'=>'required',
               
            ];
           $rule= array_merge($automative,$rule);
        }
        if ($this->request->get('table_name') == 'product_home_improvement') {
            $automative=[
                'manufacturer'=>'required',
                'type'=>'required',
             
            ];
           $rule= array_merge($automative,$rule);
        }
        
    //    dd($rule);
    //    dd($)
        return $rule;
    }
    public function messages()
{
    return [
        'distance.required' => 'Please choose one option of provided distance.',
        'age.required' => 'Please choose one option of provided age.',
       
       
    ];
}
    
}
