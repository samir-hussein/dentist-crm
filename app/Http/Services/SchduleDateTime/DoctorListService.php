<?php

namespace App\Http\Services\SchduleDateTime;

use App\Models\SchduleDate;

class DoctorListService extends SchduleDateTimeService
{
    public function boot(int $branchId, int $dayId)
    {
        $distinctDoctors = $this->model->where('branch_id', $branchId)
            ->with('doctor:id,name');

        if ($dayId != 0) {
            $datesId = SchduleDate::where("schdule_day_id", $dayId)->pluck("id")->toArray();
            $distinctDoctors->whereIn('schdule_date_id', $datesId);
        }

        $distinctDoctors = $distinctDoctors->get()
            ->map(function ($item) {
                return [
                    'id' => $item->doctor->id,
                    'name' => $item->doctor->name,
                ];
            })
            ->unique('id')
            ->values();

        return $distinctDoctors;
    }
}
