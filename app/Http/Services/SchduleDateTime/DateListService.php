<?php

namespace App\Http\Services\SchduleDateTime;

class DateListService extends SchduleDateTimeService
{
    public function boot(int $branchId, int $doctorId)
    {
        $distinctDates = $this->model
            ->where('branch_id', $branchId)
            ->where("is_deleted", 0)
            ->with(['schduleDate' => function ($q) {
                $q->where("is_holiday", 0)
                    ->select(['schdule_dates.id', 'date', 'schdule_day_id'])
                    ->orderBy('date');
            }]);

        if ($doctorId != 0) {
            $distinctDates->where('doctor_id', $doctorId);
        }

        // Fetch distinct dates by using a subquery or group by the date portion of `time`
        $distinctDates = $distinctDates->get()
            ->unique(function ($item) {
                return \Carbon\Carbon::parse($item->time)->toDateString(); // Extract the date part
            })
            ->map(function ($item) {
                return [
                    'id' => $item->schduleDate->id,
                    'dateFormated' => \Carbon\Carbon::parse($item->schduleDate->date)->format('l d-m-Y'),
                    'schdule_day_id' => $item->schduleDate->schdule_day_id,
                    'date' => $item->schduleDate->date
                ];
            })
            ->sortBy('date')
            ->values();

        return $distinctDates;
    }
}
