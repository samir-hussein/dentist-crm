<?php

namespace App\Http\Requests\Dose;

use Illuminate\Foundation\Http\FormRequest;

class DoseUpdateRequest extends FormRequest
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
        $dose = request()->route('dose')?->name;
        return [
            "dose" => "required|unique:doses,dose,$dose,dose",
        ];
    }
}
