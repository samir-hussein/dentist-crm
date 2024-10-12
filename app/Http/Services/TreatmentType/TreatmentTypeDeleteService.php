<?php

namespace App\Http\Services\TreatmentType;

use App\Models\TreatmentType;

class TreatmentTypeDeleteService extends TreatmentTypeService
{
    public function boot(TreatmentType $treatmentType)
    {
        $treatmentType->delete();

        return $this->success();
    }
}
