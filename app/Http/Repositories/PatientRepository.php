<?php

namespace App\Http\Repositories;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Interfaces\IPatient;
use App\Http\Services\Patient\PatientStoreService;
use App\Http\Services\Patient\PatientDeleteService;
use App\Http\Services\Patient\PatientGetAllService;
use App\Http\Services\Patient\PatientUpdateService;
use App\Http\Services\Patient\PatientProfileService;
use App\Http\Services\Patient\PatientFindByIdService;
use App\Http\Services\Patient\PatientNecessaryDataService;

class PatientRepository implements IPatient
{
    private $patientGetAllService;
    private $patientStoreService;
    private $patientDeleteService;
    private $patientUpdateService;
    private $patientFindByIdService;
    private $necessaryDataService;
    private $patientProfileService;

    public function __construct(
        PatientGetAllService $patientGetAllService,
        PatientStoreService $patientStoreService,
        PatientDeleteService $patientDeleteService,
        PatientUpdateService $patientUpdateService,
        PatientFindByIdService $patientFindByIdService,
        PatientNecessaryDataService $necessaryDataService,
        PatientProfileService $patientProfileService
    ) {
        $this->patientGetAllService = $patientGetAllService;
        $this->patientStoreService = $patientStoreService;
        $this->patientDeleteService = $patientDeleteService;
        $this->patientUpdateService = $patientUpdateService;
        $this->patientFindByIdService = $patientFindByIdService;
        $this->necessaryDataService = $necessaryDataService;
        $this->patientProfileService = $patientProfileService;
    }

    public function necessaryData()
    {
        return $this->necessaryDataService->boot();
    }

    public function all(Request $request)
    {
        return $this->patientGetAllService->boot($request);
    }

    public function findById(Patient $patient)
    {
        return $this->patientFindByIdService->boot($patient);
    }

    public function store(array $data)
    {
        return $this->patientStoreService->boot($data);
    }

    public function update(Patient $patient, array $data)
    {
        return $this->patientUpdateService->boot($patient, $data);
    }

    public function delete(Patient $patient)
    {
        return $this->patientDeleteService->boot($patient);
    }

    public function profile(Patient $patient)
    {
        return $this->patientProfileService->boot($patient);
    }
}
