<?php

namespace App\Http\Services\SchduleDateTime;

use App\Models\SchduleDate;

class DoctorListService extends SchduleDateTimeService
{
    public function boot(int $branchId, int $dayId)
    {
        $datesId = SchduleDate::where("schdule_day_id", $dayId)->pluck("id")->toArray();

        $distinctDoctors = $this->model->whereIn('schdule_date_id', $datesId)
            ->where('branch_id', $branchId)
            ->with('doctor:id,name')
            ->get()
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
