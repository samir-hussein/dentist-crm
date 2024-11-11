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
            ->with([
                'treatmentType',
                'treatmentType.sections',
                'treatmentType.sections.attributes',
                // Filter inputs to only include those with the specified teeth in the array
                'treatmentType.sections.attributes.inputs' => function ($inputQuery) use ($data) {
                    if ($data['tooth_type'] == "permanent") {
                        $inputQuery->where(function ($query) use ($data) {
                            foreach ($data['teeth'] as $tooth) {
                                $query->orWhereJsonContains('adultTooths', $tooth);
                            }
                        });
                    } else {
                        $inputQuery->where(function ($query) use ($data) {
                            foreach ($data['teeth'] as $tooth) {
                                $query->orWhereJsonContains('childTooths', $tooth);
                            }
                        });
                    }
                }
            ])
            ->get();

        $labs = Lab::all();
        $labsServices = LabService::all();

        return view("ajax-components.treatment-tabs", ['treatments' => $treatments, 'labs' => $labs, 'labsServices' => $labsServices])->render();
    }
}
