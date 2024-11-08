<?php

namespace App\Http\Services\Appointment;

use App\Models\Appointment;
use App\Models\SchduleDateTime;

class AppointmentUpdateService extends AppointmentService
{
    public function boot(Appointment $appointment, array $data)
    {
        if ($appointment->completed) {
            return $this->error('Cannot update completed appointment.', 403);
        }

        $check_appointment = $this->model->where("id", "!=", $appointment->id)->where("patient_id", $appointment->patient_id)->where("doctor_id", $data['doctor_id'])->where("time_id", $data['time_id'])->first();

        if ($check_appointment) {
            return $this->error("This appointment already exists.", 400);
        }

        $check_doctor_busy = $this->model->where("id", "!=", $appointment->id)->where("doctor_id", $data['doctor_id'])->where("time_id", $data['time_id'])->first();

        if ($check_doctor_busy) {
            return $this->error("The Doctor already have appointment in this time.", 400);
        }

        $appointment->update($data);

        $services = array_map(function ($service_id) use ($appointment) {
            return [
                'service_id' => $service_id,
                'appointment_id' => $appointment->id
            ];
        }, $data['service_ids']);

        $appointment->appointment_services()->delete();

        $appointment->appointment_services()->insert($services);

        return $this->success();
    }
}
