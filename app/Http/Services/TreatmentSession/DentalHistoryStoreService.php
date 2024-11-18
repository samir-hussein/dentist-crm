<?php

namespace App\Http\Services\TreatmentSession;

use App\Models\Invoice;
use App\Models\LabOrder;
use App\Models\Patient;
use App\Models\TreatmentSectionAttribute;

class DentalHistoryStoreService extends TreatmentSessionService
{
    public function boot(Patient $patient, array $data)
    {
        $treatmentSession = $this->model->create([
            'patient_id' => $patient->id,
            'diagnose_id' => $data['diagnose_id'],
            'tooth' => $data['tooth'],
            'data' => $data['data'],
            'doctor_id' => $data['doctor_id'],
            'tooth_type' => $data['tooth_type'],
        ]);

        $treatmentSession->created_at = $data['date'];
        $treatmentSession->updated_at = $data['date'];
        $treatmentSession->save();

        $treatment = TreatmentSectionAttribute::whereIn("id", $data['data']['attr'])
            ->pluck('name')
            ->unique()
            ->implode(' - ');

        $invoice = Invoice::create([
            "fees" => $data['fees'],
            "paid" => $data['paid'],
            "tooth" => $data['tooth'],
            "treatment" => $treatment,
            "tax_invoice" => $patient->need_invoice,
            'patient_id' => $patient->id,
            "treatment_detail_id" => $treatmentSession->id,
            'doctor_id' => $data['doctor_id']
        ]);

        $invoice->created_at = $data['date'];
        $invoice->updated_at = $data['date'];
        $invoice->save();

        if ($data['lab']) {
            $lab = $data['lab'];
            $lab = LabOrder::create([
                'work' => implode(" - ", $lab['work']),
                'cost' => isset($lab['cost']) ? $lab['cost'] : "",
                'done' => $lab['done'],
                'custom_data' => $lab['custom_data'],
                'tooth' => $data['tooth'],
                'sent' => $lab['sent'],
                'patient_id' => $patient->id,
                'lab_id' => $lab['lab_id'],
                "treatment_detail_id" => $treatmentSession->id,
                'created_at' => $data['date'],
                'updated_at' => $data['date'],
            ]);

            $lab->created_at = $data['date'];
            $lab->updated_at = $data['date'];
            $lab->save();
        }

        return $this->success();
    }
}
