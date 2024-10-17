<?php

namespace App\Http\Requests\Diagnosis;

use App\Models\Diagnosis;
use Illuminate\Foundation\Http\FormRequest;

class DiagnosisUpdateRequest extends FormRequest
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
        $diagnosisId = request()->route("diagnosi");
        return [
            "name" => "required|unique:diagnoses,name,$diagnosisId",
            "description" => "sometimes|nullable|string",
        ];
    }
}
