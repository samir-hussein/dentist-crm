<?php

namespace App\Http\Services\SchduleDateTime;

class DateListService extends SchduleDateTimeService
{
    public function boot(int $branchId, int $doctorId)
    {
        $distinctDates = $this->model->where('doctor_id', $doctorId)
            ->where('branch_id', $branchId)
            ->with(['schduleDate' => function ($q) {
                $q->distinct()->where("is_holiday", 0)->select(['schdule_dates.id', 'date', 'schdule_day_id'])->orderBy('date');
            }]) // Load only `id` and `date` from related schduleDate
            ->where("is_deleted", 0)->get()
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
