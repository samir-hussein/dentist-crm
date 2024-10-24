<?php

namespace App\Http\Services\Appointment;

use App\Models\Appointment;
use App\Models\SchduleDateTime;

class AppointmentDeleteService extends AppointmentService
{
    public function boot(Appointment $appointment)
    {
        if ($appointment->completed) {
            return $this->error('Cannot delete completed appointment.', 403);
        }

        SchduleDateTime::where("id", $appointment->time_id)->update([
            'patient_id' => null,
        ]);

        $appointment->delete();

        return $this->success();
    }
}
