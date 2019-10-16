<?php

namespace App\Http\Requests;

use App\Visitor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VisitorRequest extends FormRequest
{
    protected $acceptedGender = ['Male', 'Female'];
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
            'gender' => 'required|'.Rule::in(Visitor::$acceptedGender),
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
