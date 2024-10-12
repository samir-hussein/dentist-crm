<?php

namespace App\Http\Requests\TreatmentType;

use Illuminate\Foundation\Http\FormRequest;

class TreatmentTypeStoreRequest extends FormRequest
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
            "name" => "required|string|unique:treatment_types,name",
            "need_labs" => "required|boolean",
            "description" => "sometimes|nullable|string",
            "diagnosis_ids" => "required|array",
            "diagnosis_ids.*" => "required|exists:diagnoses,id",
            "sections" => "required|array",
            "sections.*" => "required|array",
            "sections.*.title" => "required|string",
            "sections.*.multi_selection" => "required|boolean",
            "sections.*.attributes" => "required|array",
            "sections.*.attributes.*" => "required|array",
            "sections.*.attributes.*.name" => "required|string",
            "sections.*.attributes.*.inputs" => "sometimes|nullable|array",
            "sections.*.attributes.*.inputs.*" => "required|array",
            "sections.*.attributes.*.inputs.*.name" => "required|string",
            "sections.*.attributes.*.inputs.*.value" => "sometimes|nullable|string",
        ];
    }
}
