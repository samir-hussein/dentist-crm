<?php

namespace App\Http\Services\Appointment;

use App\Models\Appointment;

class AppointmentCompletedService extends AppointmentService
{
    public function boot(Appointment $appointment)
    {
        if ($appointment->completed) {
            return $this->error('Appointment already completed.', 400);
        }

        $appointment->completed = true;
        $appointment->save();

        return $this->success();
    }
}
