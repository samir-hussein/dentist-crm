<?php

namespace App\Http\Services\Appointment;

use App\Http\Services\Patient\PatientStoreService;

class AppointmentStoreService extends AppointmentService
{
    private $patientStoreService;

    public function __construct(PatientStoreService $patientStoreService)
    {
        $this->patientStoreService = $patientStoreService;
    }

    public function boot(array $data)
    {
        if ($data['phone']) {
            $patient = $this->patientStoreService->boot([
                'phone' => $data['phone'],
                'name' => $data['name'],
                'gender' => $data['gender'],
                'date_of_birth' => $data['date_of_birth'],
            ]);

            $data['patient_id'] = $patient->id;
        }

        $this->model->create($data);

        return $this->success();
    }
}
