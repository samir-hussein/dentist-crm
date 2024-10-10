<?php

namespace App\Http\Services\Appointment;

use App\Models\Appointment;

class AppointmentDeleteService extends AppointmentService
{
    public function boot(Appointment $appointment)
    {
        if ($appointment->completed) {
            return $this->error('Cannot delete completed appointment.', 403);
        }

        $appointment->delete();

        return $this->success();
    }
}
