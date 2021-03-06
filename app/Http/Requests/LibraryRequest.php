<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LibraryRequest extends FormRequest
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
            'name' => 'required|max:150|min:3',
            'description' => 'required|max:250|min:3',
            'folder_id' => 'sometimes|required',
            'image' => 'sometimes|required|image|mimes:png,jpeg,jpg',
            'file' => 'sometimes|required|file|mimes:pdf,xlsx',
            'video' => 'sometimes|required|file|mimes:mp4',
            'youtube_video' => 'sometimes|required|string',
        ];
    }
}
