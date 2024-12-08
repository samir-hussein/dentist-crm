<?php

namespace App\Http\Requests\LabService;

use Illuminate\Foundation\Http\FormRequest;

class LabServiceUpdateRequest extends FormRequest
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
        $serviceName = request()->route('lab_service')?->id;
        return [
            "name" => "required|unique:lab_services,name,$serviceName,id",
        ];
    }
}
