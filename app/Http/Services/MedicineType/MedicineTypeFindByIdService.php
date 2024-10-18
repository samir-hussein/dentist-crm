<?php

namespace App\Http\Services\MedicineType;

use App\Models\MedicineType;

class MedicineTypeFindByIdService extends MedicineTypeService
{
    public function boot(MedicineType $medicineType)
    {
        return $medicineType;
    }
}
