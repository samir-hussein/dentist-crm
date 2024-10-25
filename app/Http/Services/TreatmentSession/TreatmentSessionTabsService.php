<?php

namespace App\Http\Services\TreatmentSession;

use App\Models\Diagnosis;
use App\Models\DiagnosisTreatment;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class TreatmentSessionTabsService extends TreatmentSessionService
{
    public function boot(array $data)
    {
        $treatments = DiagnosisTreatment::where("diagnosis_id", $data['diagnose'])->with(['treatmentType', 'treatmentType.sections', 'treatmentType.sections.attributes', 'treatmentType.sections.attributes.inputs'])->get();

        return view("ajax-components.treatment-tabs", ['treatments' => $treatments])->render();
    }
}
