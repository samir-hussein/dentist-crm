<?php

namespace App\Http\Services\Appointment;

use stdClass;
use App\Http\Services\Doctor\DoctorListService;
use App\Http\Services\Patient\PatientListService;
use App\Http\Services\Service\ServiceListService;
use App\Http\Services\SchduleDate\SchduleDateStoreService;
use App\Http\Services\SchduleDate\SchduleDateAvailableTimesService;

class AppointmentNecessaryDataService extends AppointmentService
{
    private $doctorListService;
    private $patientListService;
    private $serviceListService;
    private $schduleDateStoreService;
    private $schduleDateAvailableTimesService;

    public function __construct(
        DoctorListService $doctorListService,
        PatientListService $patientListService,
        ServiceListService $serviceListService,
        SchduleDateStoreService $schduleDateStoreService,
        SchduleDateAvailableTimesService $schduleDateAvailableTimesService,
    ) {
        $this->doctorListService = $doctorListService;
        $this->patientListService = $patientListService;
        $this->serviceListService = $serviceListService;
        $this->schduleDateStoreService = $schduleDateStoreService;
        $this->schduleDateAvailableTimesService = $schduleDateAvailableTimesService;
    }

    public function boot()
    {
        $this->schduleDateStoreService->boot();

        $data = new stdClass();

        $data->doctors = $this->doctorListService->boot();
        $data->patients = $this->patientListService->boot();
        $data->services = $this->serviceListService->boot();
        $data->times = $this->schduleDateAvailableTimesService->boot();

        return $data;
    }
}
