<?php

namespace App\Http\Repositories;

use Illuminate\Http\Request;
use App\Models\TreatmentType;
use App\Http\Interfaces\ITrearmentType;
use App\Http\Services\TreatmentType\TreatmentTypeStoreService;
use App\Http\Services\TreatmentType\TreatmentTypeDeleteService;
use App\Http\Services\TreatmentType\TreatmentTypeGetAllService;
use App\Http\Services\TreatmentType\TreatmentTypeUpdateService;
use App\Http\Services\TreatmentType\TreatmentTypeFindByIdService;
use App\Http\Services\TreatmentType\TreatmentTypeNecessaryDataService;

class TreatmentTypeRepository implements ITrearmentType
{
    private $treatmentTypeGetAllService;
    private $treatmentTypeStoreService;
    private $treatmentTypeDeleteService;
    private $treatmentTypeUpdateService;
    private $treatmentTypeFindByIdService;
    private $treatmentTypeNecessaryDataService;

    public function __construct(
        TreatmentTypeGetAllService $treatmentTypeGetAllService,
        TreatmentTypeStoreService $treatmentTypeStoreService,
        TreatmentTypeDeleteService $treatmentTypeDeleteService,
        TreatmentTypeUpdateService $treatmentTypeUpdateService,
        TreatmentTypeFindByIdService $treatmentTypeFindByIdService,
        TreatmentTypeNecessaryDataService $treatmentTypeNecessaryDataService,
    ) {
        $this->treatmentTypeGetAllService = $treatmentTypeGetAllService;
        $this->treatmentTypeStoreService = $treatmentTypeStoreService;
        $this->treatmentTypeDeleteService = $treatmentTypeDeleteService;
        $this->treatmentTypeUpdateService = $treatmentTypeUpdateService;
        $this->treatmentTypeFindByIdService = $treatmentTypeFindByIdService;
        $this->treatmentTypeNecessaryDataService = $treatmentTypeNecessaryDataService;
    }

    public function all(Request $request)
    {
        return $this->treatmentTypeGetAllService->boot($request);
    }

    public function findById(TreatmentType $treatmentType)
    {
        return $this->treatmentTypeFindByIdService->boot($treatmentType);
    }

    public function store(array $data)
    {
        return $this->treatmentTypeStoreService->boot($data);
    }

    public function update(TreatmentType $treatmentType, array $data)
    {
        return $this->treatmentTypeUpdateService->boot($treatmentType, $data);
    }

    public function delete(TreatmentType $treatmentType)
    {
        return $this->treatmentTypeDeleteService->boot($treatmentType);
    }

    public function necessaryData()
    {
        return $this->treatmentTypeNecessaryDataService->boot();
    }
}
