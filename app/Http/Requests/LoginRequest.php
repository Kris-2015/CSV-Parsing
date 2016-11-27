<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        return array(
            'email' => 'required|email',
            'password' => 'required|min:6'
        );
    }

    /**
     * Get the custom validation message
     *
     * @param void
     * @return array
     */
    public function messages()
    {
        return array(
            'email.required' => 'Username is mandatory',
            'password.required' => 'Password is required'
        );
    }
}
