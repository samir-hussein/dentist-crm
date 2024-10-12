<?php

namespace App\Http\Services\TreatmentType;

use stdClass;
use App\Http\Services\Diagnosis\DiagnosisListService;

class TreatmentTypeNecessaryDataService extends TreatmentTypeService
{
    private $diagnosisListService;

    public function __construct(DiagnosisListService $diagnosisListService)
    {
        $this->diagnosisListService = $diagnosisListService;
    }

    public function boot()
    {
        $data = new stdClass();

        $data->diagnosis = $this->diagnosisListService->boot();

        return $data;
    }
}
