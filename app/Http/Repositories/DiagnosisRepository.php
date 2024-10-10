<?php

namespace App\Http\Repositories;

use App\Models\Diagnosis;
use Illuminate\Http\Request;
use App\Http\Interfaces\IDiagnosis;
use App\Http\Services\Diagnosis\DiagnosisStoreService;
use App\Http\Services\Diagnosis\DiagnosisDeleteService;
use App\Http\Services\Diagnosis\DiagnosisGetAllService;
use App\Http\Services\Diagnosis\DiagnosisUpdateService;
use App\Http\Services\Diagnosis\DiagnosisFindByIdService;

class DiagnosisRepository implements IDiagnosis
{
    private $diagnosisGetAllService;
    private $diagnosisStoreService;
    private $diagnosisDeleteService;
    private $diagnosisUpdateService;
    private $diagnosisFindByIdService;

    public function __construct(
        DiagnosisGetAllService $diagnosisGetAllService,
        DiagnosisStoreService $diagnosisStoreService,
        DiagnosisDeleteService $diagnosisDeleteService,
        DiagnosisUpdateService $diagnosisUpdateService,
        DiagnosisFindByIdService $diagnosisFindByIdService,
    ) {
        $this->diagnosisGetAllService = $diagnosisGetAllService;
        $this->diagnosisStoreService = $diagnosisStoreService;
        $this->diagnosisDeleteService = $diagnosisDeleteService;
        $this->diagnosisUpdateService = $diagnosisUpdateService;
        $this->diagnosisFindByIdService = $diagnosisFindByIdService;
    }

    public function all(Request $request)
    {
        return $this->diagnosisGetAllService->boot($request);
    }

    public function findById(int $diagnosis)
    {
        return $this->diagnosisFindByIdService->boot($diagnosis);
    }

    public function store(array $data)
    {
        return $this->diagnosisStoreService->boot($data);
    }

    public function update(int $diagnosis, array $data)
    {
        return $this->diagnosisUpdateService->boot($diagnosis, $data);
    }

    public function delete(int $diagnosis)
    {
        return $this->diagnosisDeleteService->boot($diagnosis);
    }
}
