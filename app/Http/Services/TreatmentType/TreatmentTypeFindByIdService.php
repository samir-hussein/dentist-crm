<?php

namespace App\Http\Services\TreatmentType;

use App\Models\TreatmentType;

class TreatmentTypeFindByIdService extends TreatmentTypeService
{
    private $treatmentTypeNecessaryData;

    public function __construct(
        TreatmentTypeNecessaryDataService $treatmentTypeNecessaryData,
    ) {
        $this->treatmentTypeNecessaryData = $treatmentTypeNecessaryData;
    }

    public function boot(TreatmentType $treatmentType)
    {
        $treatmentType = $treatmentType->load(["diagnosis", "sections", "sections.attributes", "sections.attributes.inputs"]);
        $treatmentType->selected_diagnosis = $treatmentType->diagnosis->pluck('id')->toArray();
        unset($treatmentType->diagnosis);

        $treatmentType->diagnosis = $this->treatmentTypeNecessaryData->boot()?->diagnosis;

        return $treatmentType;
    }
}
