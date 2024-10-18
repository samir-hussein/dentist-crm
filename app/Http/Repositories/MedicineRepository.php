<?php

namespace App\Http\Repositories;

use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Http\Interfaces\IMedicine;
use App\Http\Services\Medicine\MedicineStoreService;
use App\Http\Services\Medicine\MedicineDeleteService;
use App\Http\Services\Medicine\MedicineGetAllService;
use App\Http\Services\Medicine\MedicineUpdateService;
use App\Http\Services\Medicine\MedicineFindByIdService;
use App\Http\Services\Medicine\MedicineNecessaryDataService;

class MedicineRepository implements IMedicine
{
    private $medicineGetAllService;
    private $medicineStoreService;
    private $medicineDeleteService;
    private $medicineUpdateService;
    private $medicineFindByIdService;
    private $medicineNecessaryDataService;

    public function __construct(
        MedicineGetAllService $medicineGetAllService,
        MedicineStoreService $medicineStoreService,
        MedicineDeleteService $medicineDeleteService,
        MedicineUpdateService $medicineUpdateService,
        MedicineFindByIdService $medicineFindByIdService,
        MedicineNecessaryDataService $medicineNecessaryDataService
    ) {
        $this->medicineGetAllService = $medicineGetAllService;
        $this->medicineStoreService = $medicineStoreService;
        $this->medicineDeleteService = $medicineDeleteService;
        $this->medicineUpdateService = $medicineUpdateService;
        $this->medicineFindByIdService = $medicineFindByIdService;
        $this->medicineNecessaryDataService = $medicineNecessaryDataService;
    }

    public function all(Request $request)
    {
        return $this->medicineGetAllService->boot($request);
    }

    public function findById(Medicine $medicine)
    {
        return $this->medicineFindByIdService->boot($medicine);
    }

    public function store(array $data)
    {
        return $this->medicineStoreService->boot($data);
    }

    public function update(Medicine $medicine, array $data)
    {
        return $this->medicineUpdateService->boot($medicine, $data);
    }

    public function delete(Medicine $medicine)
    {
        return $this->medicineDeleteService->boot($medicine);
    }

    public function necessaryData()
    {
        return $this->medicineNecessaryDataService->boot();
    }
}
