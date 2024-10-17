<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

class PatientStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|string",
            "phone" => "required|unique:patients,phone",
            "date_of_birth" => "required|date",
            "gender" => "required|in:Male,Female",
            "nationality" => "required|string",
            "phone2" => "sometimes|string|nullable",
            "need_invoice" => "required|boolean"
        ];
    }
}
