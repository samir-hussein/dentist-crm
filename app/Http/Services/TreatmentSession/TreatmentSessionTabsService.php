<?php

namespace App\Http\Services\TreatmentSession;

use App\Models\DiagnosisTreatment;

class TreatmentSessionTabsService extends TreatmentSessionService
{
    public function boot(array $data)
    {
        $treatments = DiagnosisTreatment::where("diagnosis_id", $data['diagnose'])->with(['treatmentType', 'treatmentType.sections', 'treatmentType.sections.attributes', 'treatmentType.sections.attributes.inputs' => function ($q) use ($data) {
            $q->whereJsonContains('adultTooths', $data['teeth'])
                ->orWhereJsonContains('childTooths', $data['teeth']);
        }])->get();

        return view("ajax-components.treatment-tabs", ['treatments' => $treatments])->render();
    }
}
