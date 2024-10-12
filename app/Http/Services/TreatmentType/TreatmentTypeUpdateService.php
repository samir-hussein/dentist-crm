<?php

namespace App\Http\Services\TreatmentType;

use App\Models\TreatmentType;

class TreatmentTypeUpdateService extends TreatmentTypeService
{
    public function boot(TreatmentType $treatmentType, array $data)
    {
        $treatmentType->update($data);

        return $this->success();
    }
}
