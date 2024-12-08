<?php

namespace App\Http\Requests\SchduleDay;

use Illuminate\Foundation\Http\FormRequest;

class SchduleDayUpdateRequest extends FormRequest
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
        $schduleDay = request()->route('schdule_day')?->id;

        return [
            "day" => "required|unique:schdule_days,day,$schduleDay,id",
            "times" => "required|array",
            "times.*" => "required|array",
            "times.*.time" => "required",
            "times" => function ($attribute, $value, $fail) {
                $uniquePairs = [];
                foreach ($value as $index => $timeEntry) {
                    $key = $timeEntry['doctor_id'] . '_' . $timeEntry['time'];
                    if (isset($uniquePairs[$key])) {
                        $fail("The time {$timeEntry['time']} is duplicated for doctor ID {$timeEntry['doctor_id']} at index $index.");
                    }
                    $uniquePairs[$key] = true;
                }
            },
            "times.*.doctor_id" => "required|exists:users,id",
            "times.*.old_time" => "required|sometimes|nullable",
            "times.*.branch_id" => "required|exists:branches,id",
        ];;
    }
}
