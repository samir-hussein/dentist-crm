<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

class PatientUpdateRequest extends FormRequest
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
        $patientPhone = request()->route("patient")?->phone;
        return [
            "name" => "required|string",
            "phone" => "required|unique:patients,phone,$patientPhone,phone",
            "age" => "required|numeric|min:1",
            "gender" => "required|in:Male,Female",
            "address" => "sometimes|string|nullable"
        ];
    }
}
