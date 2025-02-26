<?php

namespace App\Http\Requests\TreatmentSession;

use Illuminate\Foundation\Http\FormRequest;

class TreatmentSessionStoreRequest extends FormRequest
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
            "diagnose_id" => "required|exists:diagnoses,id",
            "tooth_type" => "required|string|in:permanent,deciduous",
            "tooth" => "required|array",
            "fees" => "required|numeric|min:0",
            "paid" => "required|numeric|min:0",
            "doctor_id" => "sometimes|nullable|exists:users,id",
            "data" => "required|array",
            "data.attr" => "required|array",
            "data.attr.*" => "required|exists:treatment_section_attributes,id",
            "data.inputs" => "sometimes|nullable|array",
            "data.notes" => "sometimes|nullable|string",
            "lab" => "sometimes|nullable|array",
            "lab.cost" => "sometimes|nullable|numeric|min:0",
            "lab.done" => "sometimes|boolean",
            "lab.lab_id" => "sometimes|exists:labs,id",
            "lab.sent" => "sometimes|date",
            "lab.work" => "sometimes|array",
            "lab.work.*" => "sometimes|string",
            "lab.custom_data" => "sometimes|nullable|array",
            "voice_note" => "sometimes|nullable",
        ];
    }
}
