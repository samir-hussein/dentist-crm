<?php

namespace App\Http\Services\MedicineType;

use App\Models\MedicineType;

class MedicineTypeDeleteService extends MedicineTypeService
{
    public function boot(MedicineType $medicineType)
    {
        $medicineType->delete();

        return $this->success();
    }
}
