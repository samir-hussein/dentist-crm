<?php

namespace App\Http\Services\SchduleDay;

use Illuminate\Http\Request;

class SchduleDayGetAllService extends SchduleDayService
{
    public function boot(Request $request)
    {
        // Define the correct order of days starting from Saturday
        $weekdaysOrder = [
            'saturday' => 0,
            'sunday' => 1,
            'monday' => 2,
            'tuesday' => 3,
            'wednesday' => 4,
            'thursday' => 5,
            'friday' => 6
        ];

        // Fetch all columns and order by the 'day' column using the custom weekday order
        $data = $this->model->select('*')
            ->orderByRaw("FIELD(day, ?, ?, ?, ?, ?, ?, ?)", [
                'saturday',
                'sunday',
                'monday',
                'tuesday',
                'wednesday',
                'thursday',
                'friday'
            ]);

        if (auth()->user()->is_doctor) {
            // Filter by doctor's ID if the user is a doctor
            $data->whereHas('pattern', function ($data) {
                $data->where('doctor_id', auth()->user()->id);
            });
        }

        return $this->dataTable($data, "schdule_days", $request);
    }
}
