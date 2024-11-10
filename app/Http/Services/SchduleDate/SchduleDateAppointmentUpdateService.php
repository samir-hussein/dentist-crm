<?php

namespace App\Http\Services\SchduleDate;

use Carbon\Carbon;
use App\Models\SchduleDateTime;

class SchduleDateAppointmentUpdateService extends SchduleDateService
{
    public function boot(int $appointmentId, array $data)
    {
        $time = SchduleDateTime::where("id", $appointmentId)->first();

        if (!$time) {
            return $this->error("Time not found", 404);
        }

        $time->update([
            'is_manually_updated' => true,
            'manually_updated_time' => Carbon::parse($time->time->format("d-m-Y"))->setTimeFromTimeString($data['time'])
        ]);

        return $this->success();
    }
}
