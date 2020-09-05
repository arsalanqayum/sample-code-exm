<?php

namespace App\Http\Requests;

use App\Buyers;
use Illuminate\Foundation\Http\FormRequest;

class StoreBuyerRequest extends FormRequest
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
        if($this->cell_phone){
            $if_buyer_exists = Buyers::where('cell_phone', '=', $this->cell_phone)->first();
            if($if_buyer_exists)
            {
                $id = $if_buyer_exists->id;
            }else{
                $id = 0;
            }
        }else{
            $id = 0;
        }

        return [
            'buyer_first_name'=>'required|max:100',
            'buyer_last_name'=>'required|max:100',
            'email'=>'required|email',
            'cell_phone'=>"required|unique:users|unique:buyers,cell_phone,$id",
        ];
    }
}
