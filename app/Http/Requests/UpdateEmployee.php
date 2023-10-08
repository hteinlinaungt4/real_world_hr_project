<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployee extends FormRequest
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
        $id=$this->route('employee');
        return [
            'employee_id' => 'required|unique:users,employee_id,'.$this->route('employee'),
            'name' => 'required',
            'phone' => 'required|min:9|max:11|unique:users,phone,'.$id,
            'email' => 'required|email|unique:users,email,'.$id,
            'nrc_number' => 'required',
            'gender' => 'required',
            'birthday' => 'required',
            'address' => 'required',
            'department_id' => 'required',
            'date_of_join' => 'required',
            'is_present' => 'required',
            'roles' => 'required',
            'pin_code' =>'required|max:12|min:6|unique:users,pin_code,'.$id,

        ];
    }
}
