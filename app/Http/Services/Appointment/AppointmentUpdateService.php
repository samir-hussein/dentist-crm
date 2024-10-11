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

        $check_appointment = $this->model->where("id", "!=", $appointment->id)->where("patient_id", $appointment->patient_id)->where("doctor_id", $data['doctor_id'])->where("date", $data['date'])->first();

        if ($check_appointment) {
            return $this->error("This appointment already exists.", 400);
        }

        $appointment->update($data);

        return $this->success();
    }
}
