<?php

namespace App\Http\Services\TreatmentSession;

use App\Models\Patient;
use App\Models\Appointment;
use App\Models\TreatmentSectionAttribute;

class TreatmentSessionStoreService extends TreatmentSessionService
{
    public function boot(Patient $patient, array $data)
    {
        if (request('appointment_id') && request('appointment_id') != "") {
            Appointment::where("id", request('appointment_id'))->update([
                "completed" => true
            ]);
        }

        $treatmentSession = $this->model->create([
            'patient_id' => $patient->id,
            'diagnose_id' => $data['diagnose_id'],
            'tooth' => $data['tooth'],
            'data' => $data['data'],
            'doctor_id' => isset($data['doctor_id']) ? $data['doctor_id'] : auth()->id(),
            'tooth_type' => $data['tooth_type'],
        ]);

        if (isset($data['voice_note']) && $data['voice_note'] != "") {
            $audioData = base64_decode($data['voice_note']);

            // Add the voice note to the model using Spatie Media Library
            $treatmentSession
                ->addMediaFromString($audioData) // Use the Spatie method to directly upload
                ->usingFileName('voice_note_' . time() . '.webm')
                ->toMediaCollection('voice_notes');
        }

        $treatment = TreatmentSectionAttribute::whereIn("id", $data['data']['attr'])
            ->pluck('name')
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
            'doctor_id' => isset($data['doctor_id']) ? $data['doctor_id'] : auth()->id(),
        ]);

        if ($data['lab']) {
            $lab = $data['lab'];
            $treatmentSession->labOrder()->create([
                'work' => implode(" - ", $lab['work']),
                'cost' => isset($lab['cost']) ? $lab['cost'] : "",
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
