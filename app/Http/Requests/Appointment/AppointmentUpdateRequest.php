<?php

namespace App\Http\Requests\Appointment;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentUpdateRequest extends FormRequest
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
            "doctor_id" => "required|exists:users,id",
            "branch_id" => "sometimes|nullable|exists:branches,id",
            "notes" => "sometimes|nullable|string",
            "urgent_time" => "sometimes|nullable",
            "date_id" => "sometimes|nullable|exists:schdule_dates,id",
            "time_id" => "sometimes|nullable|exists:schdule_date_times,id",
            "old_time_id" => "required|exists:schdule_date_times,id",
            "service_ids" => "required|array",
            "service_ids.*" => "required|exists:services,id"
        ];
    }
}
