<?php

namespace App\Http\Services\Appointment;

use App\Http\Services\Branch\BranchListService;
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
    private $branchesService;

    public function __construct(
        DoctorListService $doctorListService,
        PatientListService $patientListService,
        ServiceListService $serviceListService,
        SchduleDateStoreService $schduleDateStoreService,
        SchduleDateAvailableTimesService $schduleDateAvailableTimesService,
        BranchListService $branchesService,
    ) {
        $this->doctorListService = $doctorListService;
        $this->patientListService = $patientListService;
        $this->serviceListService = $serviceListService;
        $this->schduleDateStoreService = $schduleDateStoreService;
        $this->schduleDateAvailableTimesService = $schduleDateAvailableTimesService;
        $this->branchesService = $branchesService;
    }

    public function boot()
    {
        $this->schduleDateStoreService->boot();

        $data = new stdClass();

        // $data->doctors = $this->doctorListService->boot();
        $data->patients = $this->patientListService->boot();
        $data->services = $this->serviceListService->boot();
        // $data->times = $this->schduleDateAvailableTimesService->boot();
        $data->branches = $this->branchesService->boot(withDates: true);

        return $data;
    }
}
