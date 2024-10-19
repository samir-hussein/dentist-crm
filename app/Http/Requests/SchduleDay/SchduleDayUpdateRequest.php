<?php

namespace App\Http\Requests\SchduleDay;

use Illuminate\Foundation\Http\FormRequest;

class SchduleDayUpdateRequest extends SchduleDayStoreRequest
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
        $schduleDay = request()->route('schdule_day')?->day;

        $rules = parent::rules();

        $rules['day'] = "required|unique:schdule_days,day,$schduleDay,day";

        return $rules;
    }
}
