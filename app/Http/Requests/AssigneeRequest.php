<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssigneeRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'courses'=>'required',
            'CUs'=>'required',
            'staff_id'=>'required',
            'assignee_id'=>'required'
        ];
    }/**message to display */

    public function messages()
    {
        return [
            'courses.required' => 'Email is required!',
            'CUs.required' => 'Name is required!',
            'staff_id.required' => 'Password is required!',
            'assignee_id.required' => 'Assignee is required'
        ];
    }
}
