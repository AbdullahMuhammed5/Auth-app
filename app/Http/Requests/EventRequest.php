<?php

namespace App\Http\Requests;

use App\News;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'main_title' => 'required|min:3|max:150',
            'secondary_title' => 'min:3|max:250',
            'location' => 'string',
            'content'=> 'required|string',
            'images.*' => 'string',
            'visitors' => 'array|max:10'
        ];
    }
}
