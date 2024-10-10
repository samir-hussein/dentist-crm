<?php

namespace App\Http\Services\Appointment;

use App\Models\Appointment;

class AppointmentUpdateService extends AppointmentService
{
    public function boot(Appointment $appointment, array $data)
    {
        if ($appointment->completed) {
            return $this->error('Cannot update completed appointment.', 403);
        }

        $appointment->update($data);

        return $this->success();
    }
}
