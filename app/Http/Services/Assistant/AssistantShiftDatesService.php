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
        } else {
            $query->where(function ($q) use ($assistantId) {
                $q->whereJsonContains('night_shift', (string)$assistantId)->orWhereJsonContains('morning_shift', (string)$assistantId);
            });
        }

        $shifts = $query->orderBy("date")->get(["date", "morning_shift", "night_shift"]);

        $result = $shifts->map(function ($shift) use ($assistantId) {
            $shiftType = [];
            if (in_array($assistantId, $shift->morning_shift ?? [])) {
                $shiftType[] = 'morning';
            }
            if (in_array($assistantId, $shift->night_shift ?? [])) {
                $shiftType[] = 'night';
            }
            return [
                'date' => $shift->date,
                'shift' => $shiftType ?: ['morning', 'night'], // Default to "all" if both shifts apply
            ];
        });

        return $result;
    }
}
