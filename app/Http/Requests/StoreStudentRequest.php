<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:100'],

            'father_name' => ['required', 'string', 'max:100'],

            'email' => ['nullable', 'email', 'max:191', 'unique:students,email'],

            'aadhar_number' => ['required', 'digits:12', 'unique:students,aadhar_number'],

            'mobile_number' => ['required', 'string', 'max:15'],

            'address' => ['required', 'string'],

            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            'joining_date' => ['required', 'date'],

            'status' => ['sometimes', 'in:active,checked_out,inactive'],
        ];
    }
}
