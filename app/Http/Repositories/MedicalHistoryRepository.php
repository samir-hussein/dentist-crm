<?php

namespace App\Http\Repositories;

use Illuminate\Http\Request;
use App\Http\Interfaces\IMedicalHistory;
use App\Http\Services\MedicalHistory\MedicalHistoryStoreService;
use App\Http\Services\MedicalHistory\MedicalHistoryDeleteService;
use App\Http\Services\MedicalHistory\MedicalHistoryGetAllService;
use App\Http\Services\MedicalHistory\MedicalHistoryUpdateService;
use App\Http\Services\MedicalHistory\MedicalHistoryFindByIdService;
use App\Models\MedicalHistory;

class MedicalHistoryRepository implements IMedicalHistory
{
    private $medicalHistoryGetAllService;
    private $medicalHistoryStoreService;
    private $medicalHistoryDeleteService;
    private $medicalHistoryFindById;
    private $medicalHistoryUpdateService;

    public function __construct(
        MedicalHistoryGetAllService $medicalHistoryGetAllService,
        MedicalHistoryStoreService $medicalHistoryStoreService,
        MedicalHistoryDeleteService $medicalHistoryDeleteService,
        MedicalHistoryFindByIdService $medicalHistoryFindById,
        MedicalHistoryUpdateService $medicalHistoryUpdateService
    ) {
        $this->medicalHistoryGetAllService = $medicalHistoryGetAllService;
        $this->medicalHistoryStoreService = $medicalHistoryStoreService;
        $this->medicalHistoryDeleteService = $medicalHistoryDeleteService;
        $this->medicalHistoryFindById = $medicalHistoryFindById;
        $this->medicalHistoryUpdateService = $medicalHistoryUpdateService;
    }

    public function all(Request $request)
    {
        return $this->medicalHistoryGetAllService->boot($request);
    }

    public function findById(MedicalHistory $medicalHistory)
    {
        return $this->medicalHistoryFindById->boot($medicalHistory);
    }

    public function store(array $data)
    {
        return $this->medicalHistoryStoreService->boot($data);
    }

    public function update(MedicalHistory $medicalHistory, array $data)
    {
        return $this->medicalHistoryUpdateService->boot($medicalHistory, $data);
    }

    public function delete(MedicalHistory $medicalHistory)
    {
        return $this->medicalHistoryDeleteService->boot($medicalHistory);
    }
}
