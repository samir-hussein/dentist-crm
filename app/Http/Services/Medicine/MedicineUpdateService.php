<?php

namespace App\Http\Services\Medicine;

use App\Models\Medicine;

class MedicineUpdateService extends MedicineService
{
    public function boot(Medicine $medicine, array $data)
    {
        $medicine->update($data);

        return $this->success();
    }
}
