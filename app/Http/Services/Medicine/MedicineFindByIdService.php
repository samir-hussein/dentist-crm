<?php

namespace App\Http\Services\Medicine;

use App\Models\Medicine;

class MedicineFindByIdService extends MedicineService
{
    private $medicineNecessaryData;

    public function __construct(
        MedicineNecessaryDataService $medicineNecessaryData,
    ) {
        $this->medicineNecessaryData = $medicineNecessaryData;
    }

    public function boot(Medicine $medicine)
    {
        $medicine = $medicine->load("medicineType");

        $medicine->medicineTypes = $this->medicineNecessaryData->boot()?->medicineTypes;

        return $medicine;
    }
}
