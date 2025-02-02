<?php

namespace App\Http\Requests\Medicine;

use Illuminate\Foundation\Http\FormRequest;

class MedicineUpdateRequest extends FormRequest
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
        $medicine = request()->route('medicine')?->id;
        return [
            "name" => "required|unique:medicines,name,$medicine,id",
            'description' => "sometimes|nullable|string",
            'medicine_type_id' => "required|exists:medicine_types,id"
        ];
    }
}
