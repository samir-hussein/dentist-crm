<?php

namespace App\Http\Services\Patient;

use App\Models\Patient;

class PatientFindByIdService extends PatientService
{
    private $patientNecessaryData;

    public function __construct(
        PatientNecessaryDataService $patientNecessaryData,
    ) {
        $this->patientNecessaryData = $patientNecessaryData;
    }

    public function boot(Patient $patient)
    {
        $data = new \stdClass();
        $data->patient = $patient;
        $data->patient->medical_history = $patient->medical_history ? explode(" - ", $patient->medical_history) : [];
        $data->medicalHistory = $this->patientNecessaryData->boot()->medicalHistory;
        return $data;
    }
}
