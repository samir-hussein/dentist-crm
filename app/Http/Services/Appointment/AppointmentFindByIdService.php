<?php

namespace App\Http\Services\Appointment;

use App\Models\Appointment;

class AppointmentFindByIdService extends AppointmentService
{
    public function boot(Appointment $appointment)
    {
        return $appointment->load(["patient", "services", "doctor"]);
    }
}
