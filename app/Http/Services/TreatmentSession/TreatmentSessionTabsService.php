<?php

namespace App\Http\Services\TreatmentSession;

use App\Models\DiagnosisTreatment;
use App\Models\Lab;
use App\Models\LabService;

class TreatmentSessionTabsService extends TreatmentSessionService
{
    public function boot(array $data)
    {
        $treatments = DiagnosisTreatment::where("diagnosis_id", $data['diagnose'])
            ->whereHas('treatmentType', function ($q) use ($data) {
                $q->where("tooth_type", $data['tooth_type']);
            })
            ->where(function ($query) use ($data) {
                $query->whereHas('treatmentType.sections.attributes.inputs', function ($q) use ($data) {
                    if ($data['tooth_type'] == "permanent") {
                        $q->whereJsonContains('adultTooths', $data['teeth'])
                            ->orWhere("adultTooths", null); // Match null or the tooth
                    } else {
                        $q->whereJsonContains('childTooths', $data['teeth'])
                            ->orWhere("childTooths", null); // Match null or the tooth
                    }
                })
                    ->orWhereDoesntHave('treatmentType.sections.attributes.inputs'); // Allow treatments with no inputs
            })
            ->with([
                'treatmentType',
                'treatmentType.sections',
                'treatmentType.sections.attributes',
                'treatmentType.sections.attributes.inputs'
            ])
            ->get();

        $labs = Lab::all();
        $labsServices = LabService::all();

        return view("ajax-components.treatment-tabs", ['treatments' => $treatments, 'labs' => $labs, 'labsServices' => $labsServices])->render();
    }
}
