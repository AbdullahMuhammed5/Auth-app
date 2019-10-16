<?php

namespace App\Http\Requests;

use App\News;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
            'author_id' => 'required|int',
            'type' => 'required|'.Rule::in(News::$types),
            'content'=> 'required|string',
            'images.*' => 'string',
            'files.*' => 'string',
            'related' => 'array|max:10'
        ];
    }
}
