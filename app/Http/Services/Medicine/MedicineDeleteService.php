<?php

namespace App\Http\Services\Medicine;

use App\Models\Medicine;

class MedicineDeleteService extends MedicineService
{
    public function boot(Medicine $medicine)
    {
        $medicine->delete();

        return $this->success();
    }
}
