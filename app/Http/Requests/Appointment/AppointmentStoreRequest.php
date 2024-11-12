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
            "phone2" => "sometimes|string|nullable",
            "date_of_birth" => "required_with:phone|date",
            "nationality" => "sometimes|nullable|string",
            "gender" => "required_with:phone|in:Male,Female",
            "patient_id" => "exists:patients,id|required_without:phone",
            "doctor_id" => "required|exists:users,id",
            "branch_id" => "sometimes|nullable|exists:branches,id",
            "notes" => "sometimes|nullable|string",
            "time_id" => "required|exists:schdule_date_times,id",
            "service_ids" => "required|array",
            "service_ids.*" => "required|exists:services,id"
        ];
    }
}
