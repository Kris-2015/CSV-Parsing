<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
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
            'name' => 'required|alpha',
            'email' => 'required|email',
            'password' => 'required|min:6'
        );
    }

    /**
     * Get the custom message of the validation error
     *
     * @return array
     */
    public function messages()
    {
        return array(
            'name.required' => 'Giving Name is mandatory',
            'name.alpha' => 'Name should be in alphabet',
            'email.requied' => 'email is mandatory',
            'password.required' => 'Password is mandatory'
        );
    }
}
