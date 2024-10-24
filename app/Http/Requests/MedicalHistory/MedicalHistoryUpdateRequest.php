<?php

namespace App\Http\Requests\MedicalHistory;

use Illuminate\Foundation\Http\FormRequest;

class MedicalHistoryUpdateRequest extends FormRequest
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
        $medicalHistory = request()->route('medical_history')?->name;
        return [
            "name" => "required|unique:medical_histories,name,$medicalHistory,name",
        ];
    }
}
