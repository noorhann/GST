<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CreateUsersRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => [
                'required',
                'digits:11',
                'regex:/[01]{2}[0-9]{9}/',
            ],
            'birth_date' => ['required'],
            'email' =>  ['required', 'regex:/(.+)@(.+)\.(.+)/', 'email', 'string', 'max:100', Rule::unique('users')->whereNull('deleted_at')],
            'password' => 'required|string|confirmed|min:6',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([

            'success'   => false,

            'message'   => 'validation error',

            'data'      => $validator->errors()

        ],400));
    }
}
