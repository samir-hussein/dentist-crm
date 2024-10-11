<?php

namespace App\Http\Services\Appointment;

use stdClass;
use App\Http\Services\Doctor\DoctorListService;
use App\Http\Services\Patient\PatientListService;
use App\Http\Services\Service\ServiceListService;

class AppointmentNecessaryDataService extends AppointmentService
{
    private $doctorListService;
    private $patientListService;
    private $serviceListService;

    public function __construct(
        DoctorListService $doctorListService,
        PatientListService $patientListService,
        ServiceListService $serviceListService
    ) {
        $this->doctorListService = $doctorListService;
        $this->patientListService = $patientListService;
        $this->serviceListService = $serviceListService;
    }

    public function boot()
    {
        $data = new stdClass();

        $data->doctors = $this->doctorListService->boot();
        $data->patients = $this->patientListService->boot();
        $data->services = $this->serviceListService->boot();

        return $data;
    }
}
