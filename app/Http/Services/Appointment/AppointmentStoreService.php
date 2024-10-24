<?php

namespace App\Http\Services\Appointment;

use App\Http\Services\Patient\PatientStoreService;
use App\Models\Appointment;
use App\Models\SchduleDateTime;

class AppointmentStoreService extends AppointmentService
{
    private $patientStoreService;

    public function __construct(PatientStoreService $patientStoreService, Appointment $model)
    {
        $this->patientStoreService = $patientStoreService;
        parent::__construct($model);
    }

    public function boot(array $data)
    {
        if (isset($data['phone']) && $data['phone']) {
            $patient = $this->patientStoreService->boot([
                'phone' => $data['phone'],
                'name' => $data['name'],
                'nationality' => $data['nationality'],
                'phone2' => isset($data['phone2']) ? $data['phone2'] : null,
                'gender' => $data['gender'],
                'date_of_birth' => $data['date_of_birth'],
            ]);

            $data['patient_id'] = $patient->id;
        }

        $check_appointment = $this->model->where("patient_id", $data['patient_id'])->where("doctor_id", $data['doctor_id'])->where("time_id", $data['time_id'])->first();

        if ($check_appointment) {
            return $this->error("This appointment already exists.", 400);
        }

        $appointment = $this->model->create($data);

        $services = array_map(function ($service_id) use ($appointment) {
            return [
                'service_id' => $service_id,
                'appointment_id' => $appointment->id
            ];
        }, $data['service_ids']);

        $appointment->appointment_services()->insert($services);

        SchduleDateTime::where("id", $data['time_id'])->update([
            'patient_id' => $data['patient_id'],
        ]);

        return $this->success();
    }
}
