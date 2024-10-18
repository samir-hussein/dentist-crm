<?php

namespace App\Http\Services\MedicineType;

use App\Models\MedicineType;

class MedicineTypeUpdateService extends MedicineTypeService
{
    public function boot(MedicineType $medicineType, array $data)
    {
        $medicineType->update($data);

        return $this->success();
    }
}
