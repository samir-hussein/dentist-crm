<?php

namespace App\Http\Services\SchduleDate;

use App\Models\SchduleDateTime;

class SchduleDateAppointmentDeleteService extends SchduleDateService
{
    public function boot(int $appointmentId)
    {
        if (!SchduleDateTime::where("id", $appointmentId)->update([
            'is_deleted' => true,
        ])) {
            return $this->error("Appointment deletion failed", 404);
        }



        return $this->success();
    }
}
