<?php

namespace App\Http\Services\Shift;

use App\Models\Assistant;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShiftGetAllService extends ShiftService
{
    public function boot(Request $request)
    {
        $date = $request->input('date', now()->format('Y-m')); // Default to the current month if 'date' is not provided
        [$year, $month] = explode('-', $date);

        // Ensure $month and $year are integers
        $month = (int)$month;
        $year = (int)$year;

        $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;

        // Fetch shifts for the given month and year
        $shifts = $this->model
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get(['date', 'morning_shift', 'night_shift'])
            ->keyBy('date')
            ->toArray();


        return [
            'shifts' => $shifts,
            'daysInMonth' => $daysInMonth,
            'month' => $month,
            'year' => $year,
        ];
    }
}
