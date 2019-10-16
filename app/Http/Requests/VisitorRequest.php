<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisitorRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|numeric|unique:users,id,'.$this->checkIdExists(),
            'email' => 'required|email|unique:users,id,'.$this->checkIdExists(),
            'gender' => 'required|string',
            'file' => 'image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function checkIdExists(){
        if($this->id){
            return $this->id;
        }
        return false;
    }
}
