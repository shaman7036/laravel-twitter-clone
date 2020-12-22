<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'username' => 'required|string|max:16',
            'email' => 'required|string|email|max:32',
            'fullname' => 'nullable|string|max:64',
            'description' => 'nullable|string|max:256',
            'location' => 'nullable|max:128',
            'website' => 'nullable|max:128',
            'bg' => 'nullable|mimes:jpeg,jpg,png,gif|max:128',
            'avatar' => 'nullable|mimes:jpeg,jpg,png,gif|max:128',
        ];
    }

    public function messages()
    {
        return [];
    }
}
