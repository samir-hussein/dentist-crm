<?php

namespace App\Http\Requests\SchduleDay;

use Illuminate\Foundation\Http\FormRequest;

class SchduleDayStoreRequest extends FormRequest
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
            "day" => "required|unique:schdule_days,day",
            "times" => "required|array",
            "times.*" => "required"
        ];
    }
}
