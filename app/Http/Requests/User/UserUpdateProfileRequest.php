<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateProfileRequest extends FormRequest
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
            "name" => "required|string|max:255",
            "gender" => "required|string|in:Male,Female",
            "email" => "required|email|unique:users,email," . auth()->user()->id,
            "phone" => "sometimes|nullable|string",
            "avatar" => "nullable|image|mimes:jpeg,png,jpg,webp|max:20480",
            "current_password" => "sometimes|nullable|string|required_with:new_password",
            "new_password" => "sometimes|nullable|string|min:8|confirmed|different:current_password",
        ];
    }
}
