<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user'         => 'required',
            'username'     => 'required|max:50',
            'email'        => 'nullable|email',
            'phone1'       => 'required',
            'roles'        => 'required',
            'status'       => 'required',
        ];
    }
}
