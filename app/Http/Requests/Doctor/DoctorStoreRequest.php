<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class DoctorStoreRequest extends FormRequest
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
            "name" => "required",
            "email" => "required|email:filter|unique:users,email",
            "password" => "required|min:8|string|confirmed",
            "phone" => "required|string",
            "gender" => "required|in:Male,Female",
            "finance" => "required|boolean",
            "avatar" => "sometimes|nullable|image|mimes:jpeg,png,jpg|max:20480"
        ];
    }
}
