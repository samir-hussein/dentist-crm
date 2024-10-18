<?php

namespace App\Http\Repositories;

use App\Models\LabService;
use App\Models\MedicineType;
use Illuminate\Http\Request;
use App\Http\Interfaces\IMedicineType;
use App\Http\Services\MedicineType\MedicineTypeStoreService;
use App\Http\Services\MedicineType\MedicineTypeDeleteService;
use App\Http\Services\MedicineType\MedicineTypeGetAllService;
use App\Http\Services\MedicineType\MedicineTypeUpdateService;
use App\Http\Services\MedicineType\MedicineTypeFindByIdService;

class MedicineTypeRepository implements IMedicineType
{
    private $medicineTypeGetAllService;
    private $medicineTypeStoreService;
    private $medicineTypeDeleteService;
    private $medicineTypeFindByIdService;
    private $medicineTypeUpdateService;

    public function __construct(
        MedicineTypeGetAllService $medicineTypeGetAllService,
        MedicineTypeStoreService $medicineTypeStoreService,
        MedicineTypeDeleteService $medicineTypeDeleteService,
        MedicineTypeFindByIdService $medicineTypeFindByIdService,
        MedicineTypeUpdateService $medicineTypeUpdateService
    ) {
        $this->medicineTypeGetAllService = $medicineTypeGetAllService;
        $this->medicineTypeStoreService = $medicineTypeStoreService;
        $this->medicineTypeDeleteService = $medicineTypeDeleteService;
        $this->medicineTypeFindByIdService = $medicineTypeFindByIdService;
        $this->medicineTypeUpdateService = $medicineTypeUpdateService;
    }

    public function all(Request $request)
    {
        return $this->medicineTypeGetAllService->boot($request);
    }

    public function findById(MedicineType $medicineType)
    {
        return $this->medicineTypeFindByIdService->boot($medicineType);
    }

    public function store(array $data)
    {
        return $this->medicineTypeStoreService->boot($data);
    }

    public function update(MedicineType $medicineType, array $data)
    {
        return $this->medicineTypeUpdateService->boot($medicineType, $data);
    }

    public function delete(MedicineType $medicineType)
    {
        return $this->medicineTypeDeleteService->boot($medicineType);
    }
}
