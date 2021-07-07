<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterUser extends FormRequest
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
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->whereNull('deleted_at')
            ],
            'password' => 'required|min:6',
            'confirmPassword' => 'required|min:6|same:password',
            'sex' => 'required',
        ];
    }
    // public function messages()
    // {
    //     return [
    //         'name.required' => 'This field is required',
    //         'email.required' => 'This field is required',
    //         'password.required' => 'This field is required',
    //         'confirmPassword.required' => 'This field is required',
    //         'sex.required' => 'This field is required',
    //     ];
    // }
}
