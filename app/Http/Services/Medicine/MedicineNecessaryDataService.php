<?php

namespace App\Http\Services\Medicine;

use stdClass;
use App\Http\Services\Medicine\MedicineService;
use App\Http\Services\MedicineType\MedicineTypeListService;

class MedicineNecessaryDataService extends MedicineService
{
    private $medicineTypeListService;

    public function __construct(MedicineTypeListService $medicineTypeListService)
    {
        $this->medicineTypeListService = $medicineTypeListService;
    }

    public function boot()
    {
        $data = new stdClass();

        $data->medicineTypes = $this->medicineTypeListService->boot();

        return $data;
    }
}
