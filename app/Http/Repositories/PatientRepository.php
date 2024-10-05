<?php

namespace App\Http\Repositories;

use App\Models\Patient;
use App\Http\Interfaces\IPatient;
use App\Http\Services\Patient\PatientDeleteService;
use App\Http\Services\Patient\PatientGetAllService;
use App\Http\Services\Patient\PatientStoreService;
use Illuminate\Http\Request;

class PatientRepository implements IPatient
{
    private $patientGetAllService;
    private $patientStoreService;
    private $patientDeleteService;

    public function __construct(PatientGetAllService $patientGetAllService, PatientStoreService $patientStoreService, PatientDeleteService $patientDeleteService)
    {
        $this->patientGetAllService = $patientGetAllService;
        $this->patientStoreService = $patientStoreService;
        $this->patientDeleteService = $patientDeleteService;
    }

    public function all(Request $request)
    {
        return $this->patientGetAllService->boot($request);
    }

    public function findById(Patient $id)
    {
        //
    }

    public function store(array $data)
    {
        return $this->patientStoreService->boot($data);
    }

    public function update(Patient $id, array $data)
    {
        //
    }

    public function delete(Patient $patient)
    {
        return $this->patientDeleteService->boot($patient);
    }
}
