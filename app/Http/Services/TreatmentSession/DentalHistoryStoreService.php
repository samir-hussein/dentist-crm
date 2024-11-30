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
        $treatment = TreatmentSectionAttribute::whereIn("id", $data['data']['attr'])
            ->with(['treatmentSection.treatmentType' => function ($q) {
                $q->select(['treatment_types.id', 'name']);
            }])
            ->get()
            ->pluck('treatmentSection.treatmentType.name')
            ->unique()
            ->implode(' - ');

        $treatmentSession = $this->model->create([
            'patient_id' => $patient->id,
            'diagnose_id' => $data['diagnose_id'],
            'tooth' => $data['tooth'],
            'data' => $data['data'],
            'doctor_id' => $data['doctor_id'],
            'tooth_type' => $data['tooth_type'],
            'treatment' => $treatment
        ]);

        $treatmentSession->created_at = $data['date'];
        $treatmentSession->updated_at = $data['date'];
        $treatmentSession->save();

        if (isset($data['voice_note']) && $data['voice_note'] != "") {
            $audioData = base64_decode($data['voice_note']);

            // Add the voice note to the model using Spatie Media Library
            $treatmentSession
                ->addMediaFromString($audioData) // Use the Spatie method to directly upload
                ->usingFileName('voice_note_' . time() . '.webm')
                ->toMediaCollection('voice_notes');
        }


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
