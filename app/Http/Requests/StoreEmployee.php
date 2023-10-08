<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployee extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'employee_id' => 'required|unique:users,employee_id',
            'name' => 'required',
            'phone' => 'required|min:9|max:11|unique:users,phone',
            'email' => 'required|email|unique:users,email',
            'nrc_number' => 'required',
            'gender' => 'required',
            'birthday' => 'required',
            'address' => 'required',
            'department_id' => 'required',
            'date_of_join' => 'required',
            'is_present' => 'required',
            'password' => 'required',
            'image' => 'mimes:jpg,bmp,png',
            'roles' => 'required',
            'pin_code'=>'required|max:12|min:6|unique:users,pin_code',
        ];
    }
}
