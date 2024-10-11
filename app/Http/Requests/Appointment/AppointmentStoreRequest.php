<?php

namespace App\Http\Requests\Appointment;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentStoreRequest extends FormRequest
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
            "name" => "string|required_with:phone",
            "phone" => "unique:patients,phone|required_without:patient_id",
            "date_of_birth" => "required_with:phone|date",
            "gender" => "required_with:phone|in:Male,Female",
            "patient_id" => "exists:patients,id|required_without:phone",
            "doctor_id" => "required|exists:users,id",
            "notes" => "sometimes|nullable|string",
            "date" => "required|date",
            "time" => "required",
            "service_ids" => "required|array",
            "service_ids.*" => "required|exists:services,id"
        ];
    }
}
