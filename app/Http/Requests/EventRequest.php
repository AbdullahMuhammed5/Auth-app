<?php

namespace App\Http\Requests;

use App\News;
use Carbon\Carbon;
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
//            'start_date' => 'required|after_or_equal:'.Carbon::today()->toDateString(),
            'start_date' => 'required',
            'end_date' => 'required|after_or_equal:start_date',
            'images.*' => 'string',
            'cover' => 'required|string',
            'visitors' => 'array|max:10'
        ];
    }
}
