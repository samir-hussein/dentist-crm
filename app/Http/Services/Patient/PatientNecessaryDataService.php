<?php

namespace App\Http\Services\Patient;

use stdClass;
use App\Http\Services\MedicalHistory\MedicalHistoryListService;

class PatientNecessaryDataService extends PatientService
{
    private $medicalHistoryListService;

    public function __construct(MedicalHistoryListService $medicalHistoryListService)
    {
        $this->medicalHistoryListService = $medicalHistoryListService;
    }

    public function boot()
    {
        $data = new stdClass();

        $data->medicalHistory = $this->medicalHistoryListService->boot();

        return $data;
    }
}
