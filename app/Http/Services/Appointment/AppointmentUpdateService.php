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

        if ($appointment->time_id != $data['time_id']) {
            SchduleDateTime::where("id", $data['time_id'])->update([
                'patient_id' => $appointment->patient_id,
            ]);

            SchduleDateTime::where("id", $appointment->time_id)->update([
                'patient_id' => null,
            ]);
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
