<?php

namespace App\Http\Requests\ExpenseHead;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseheadStoreRequest extends FormRequest
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
            'name' => 'required|unique:expense_heads,name'
        ];
    }
}
