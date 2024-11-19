<?php

namespace App\Http\Services\Shift;

class ShiftStoreService extends ShiftService
{
    public function boot(int $assistant_id, array $data)
    {
        $shifts = $data['shifts'];

        $insert = [];
        $submittedDates = array_keys($shifts);

        // Extract the month and year from the first submitted date
        $firstSubmittedDate = reset($submittedDates);
        $submittedMonth = date('m', strtotime($firstSubmittedDate));
        $submittedYear = date('Y', strtotime($firstSubmittedDate));

        // Calculate the start and end of the submitted month
        $startOfSubmittedMonth = now()->create($submittedYear, $submittedMonth, 1)->startOfMonth();
        $endOfSubmittedMonth = $startOfSubmittedMonth->copy()->endOfMonth();

        // Prepare data for insert/update
        foreach ($shifts as $date => $shift) {
            $morning = isset($shift['morning']) ? true : false;
            $night = isset($shift['night']) ? true : false;

            $insert[] = [
                'date' => $date,
                'morning_shift' => $morning,
                'night_shift' => $night,
                'assistant_id' => $assistant_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Remove shifts not submitted within the same month
        $this->model->where('assistant_id', $assistant_id)
            ->whereBetween('date', [$startOfSubmittedMonth, $endOfSubmittedMonth])
            ->whereNotIn('date', $submittedDates)
            ->delete();

        // Insert or update the remaining shifts
        if (count($insert) > 0) {
            $this->model->upsert(
                $insert, // Data to insert/update
                ['assistant_id', 'date'], // Unique keys to check for existing rows
                ['morning_shift', 'night_shift', 'updated_at'] // Columns to update if a row already exists
            );
        }

        return $this->success();
    }
}
