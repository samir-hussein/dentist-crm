<?php

namespace App\Http\Services\SchduleDateTime;

use Carbon\Carbon;
use App\Models\SchduleDate;

class TimesListService extends SchduleDateTimeService
{
    public function boot(int $branchId, int $doctorId, int $dateId)
    {
        $currentTime = Carbon::now();
        $times = $this->model->where("schdule_date_id", $dateId)
            ->where("branch_id", $branchId)
            ->where("doctor_id", $doctorId)
            ->where("is_deleted", 0)
            ->whereNull("patient_id")
            ->where("time", ">=", $currentTime)
            ->orderBy("time")
            ->get(['id', 'time', 'manually_updated_time'])
            ->map(function ($time) {
                return [
                    "id" => $time->id,
                    "timeFormated" => $time->manually_updated_time ? $time->manually_updated_time->format("h:i a") : $time->time->format("h:i a"),
                ];
            });

        return $times;
    }
}
