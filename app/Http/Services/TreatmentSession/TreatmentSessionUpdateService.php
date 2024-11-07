<?php

namespace App\Http\Services\TreatmentSession;

use App\Models\Patient;
use App\Models\TreatmentDetail;
use App\Models\TreatmentSectionAttribute;

class TreatmentSessionUpdateService extends TreatmentSessionService
{
    public function boot(TreatmentDetail $treatmentDetail, Patient $patient, array $data)
    {
        $treatmentDetail->update([
            'data' => $data['data'],
        ]);

        $treatment = TreatmentSectionAttribute::whereIn("id", $data['data']['attr'])
            ->with(['treatmentSection.treatmentType' => function ($q) {
                $q->select(['treatment_types.id', 'name']);
            }])
            ->get()
            ->pluck('treatmentSection.treatmentType.name')
            ->unique()
            ->implode(' - ');

        if ($data['paid'] > 0) {
            $treatmentDetail->invoice()->create([
                "fees" => 0,
                "paid" => $data['paid'],
                "tooth" => $treatmentDetail->tooth,
                "treatment" => "Follow Up For Date : " . $treatmentDetail->created_at->format("Y-m-d"),
                "tax_invoice" => $patient->need_invoice,
                'patient_id' => $patient->id,
                "treatment_detail_id" => $treatmentDetail->id,
                'doctor_id' => auth()->id()
            ]);
        }

        if ($data['lab']) {
            $lab = $data['lab'];
            $treatmentDetail->labOrder()->updateOrCreate([
                "treatment_detail_id" => $treatmentDetail->id
            ], [
                'work' => implode(" - ", $lab['work']),
                'cost' => $lab['cost'],
                'done' => $lab['done'],
                'custom_data' => $lab['custom_data'],
                'tooth' => $treatmentDetail->tooth,
                'sent' => $lab['sent'],
                'patient_id' => $patient->id,
                'lab_id' => $lab['lab_id'],
            ]);
        }

        return $this->success();
    }
}
