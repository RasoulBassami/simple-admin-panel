<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255', Rule::unique('posts', 'title')->ignore($this->post)],
            'description' => ['required','string', 'min:3', 'max:1000'],
            'body' => ['required', 'string', 'min:3'],
            'images.*' => ['image', 'mimes:jpg,png,jpeg', 'max:2048'],
        ];
    }
}
