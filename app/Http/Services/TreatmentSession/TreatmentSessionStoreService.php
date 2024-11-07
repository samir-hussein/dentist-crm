<?php

namespace App\Http\Services\TreatmentSession;

use App\Models\Patient;
use App\Models\TreatmentSectionAttribute;

class TreatmentSessionStoreService extends TreatmentSessionService
{
    public function boot(Patient $patient, array $data)
    {
        $treatmentSession = $this->model->create([
            'patient_id' => $patient->id,
            'diagnose_id' => $data['diagnose_id'],
            'tooth' => $data['tooth'],
            'data' => $data['data'],
            'doctor_id' => auth()->id()
        ]);

        $treatment = TreatmentSectionAttribute::whereIn("id", $data['data']['attr'])
            ->with(['treatmentSection.treatmentType' => function ($q) {
                $q->select(['treatment_types.id', 'name']);
            }])
            ->get()
            ->pluck('treatmentSection.treatmentType.name')
            ->unique()
            ->implode(' - ');

        $treatmentSession->invoice()->create([
            "fees" => $data['fees'],
            "paid" => $data['paid'],
            "tooth" => $data['tooth'],
            "treatment" => $treatment,
            "tax_invoice" => $patient->need_invoice,
            'patient_id' => $patient->id,
            "treatment_detail_id" => $treatmentSession->id,
            'doctor_id' => auth()->id()
        ]);

        if ($data['lab']) {
            $lab = $data['lab'];
            $treatmentSession->labOrder()->create([
                'work' => implode(" - ", $lab['work']),
                'cost' => $lab['cost'],
                'done' => $lab['done'],
                'custom_data' => $lab['custom_data'],
                'tooth' => $data['tooth'],
                'sent' => $lab['sent'],
                'patient_id' => $patient->id,
                'lab_id' => $lab['lab_id'],
                "treatment_detail_id" => $treatmentSession->id
            ]);
        }

        return $this->success();
    }
}
