<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function checkEmailExists(){
        if($this->email){
            return $this->email;
        }else{
            return false;
        }
    }

    public function checkPhoneExists(){
        if($this->phone){
            return $this->phone;
        }
        return false;
    }

    public function checkIdExists(){
        if($this->id){
            return $this->id;
        }
        return false;
    }
}
