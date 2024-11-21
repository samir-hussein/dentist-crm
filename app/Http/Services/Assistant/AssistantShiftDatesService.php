<?php

namespace App\Http\Services\Assistant;

use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AssistantShiftDatesService extends AssistantService
{
    public function boot(int $assistantId, string $from, string $to, string $shift)
    {
        $startDate = Carbon::parse($from)->startOfDay();

        $endDate = Carbon::parse($to)->endOfDay();

        $query = Shift::whereBetween('date', [$startDate, $endDate]);

        if ($shift == "morning") {
            // Make sure the assistant ID exists in the morning_shift JSON column
            $query->whereJsonContains('morning_shift', (string)$assistantId);
        } elseif ($shift == "night") {
            // Make sure the assistant ID exists in the night_shift JSON column
            $query->whereJsonContains('night_shift', (string)$assistantId);
        }

        return $query->orderBy("date")->pluck("date");
    }
}
