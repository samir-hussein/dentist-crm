<?php

namespace App\Http\Services\SchduleDate;

class SchduleDateAvailableTimesService extends SchduleDateService
{
    public function boot()
    {
        return $this->model->where("is_holiday", false)->orderBy("date")->with(['appointments' => function ($q) {
            $q->where('is_deleted', false)->orderBy("time");
        }])->get()->map(function ($date) {
            $date->appointments->map(function ($appointment) {
                $appointment->timeFormated = $appointment->time->format('h:i a');
                $appointment->manuallyUpdatedTime = $appointment->manually_updated_time?->format("h:i a");
                return $appointment;
            });

            return $date;
        });
    }
}
