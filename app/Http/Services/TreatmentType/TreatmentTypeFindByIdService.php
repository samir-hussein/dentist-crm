<?php

namespace App\Http\Services\TreatmentType;

use App\Models\TreatmentType;

class TreatmentTypeFindByIdService extends TreatmentTypeService
{
    public function boot(TreatmentType $treatmentType)
    {
        return $treatmentType;
    }
}
