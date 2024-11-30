<?php

namespace App\Http\Services\TreatmentSession;

use App\Models\Patient;
use App\Models\Appointment;
use App\Models\TreatmentDetail;
use App\Models\TreatmentSectionAttribute;

class TreatmentSessionUpdateService extends TreatmentSessionService
{
    public function boot(TreatmentDetail $treatmentDetail, Patient $patient, array $data)
    {
        if (request('appointment_id') && request('appointment_id') != "") {
            Appointment::where("id", request('appointment_id'))->update([
                "completed" => true
            ]);
        }

        $treatment = TreatmentSectionAttribute::whereIn("id", $data['data']['attr'])
            ->with(['treatmentSection.treatmentType' => function ($q) {
                $q->select(['treatment_types.id', 'name']);
            }])
            ->get()
            ->pluck('treatmentSection.treatmentType.name')
            ->unique()
            ->implode(' - ');

        $treatmentDetail->update([
            'data' => $data['data'],
            'doctor_id' => isset($data['doctor_id']) ? $data['doctor_id'] : auth()->id(),
            'treatment' => $treatment
        ]);

        if (isset($data['voice_note']) && $data['voice_note'] != "") {
            $treatmentDetail->clearMediaCollection('voice_notes');

            $audioData = base64_decode($data['voice_note']);

            // Add the voice note to the model using Spatie Media Library
            $treatmentDetail
                ->addMediaFromString($audioData) // Use the Spatie method to directly upload
                ->usingFileName('voice_note_' . time() . '.webm')
                ->toMediaCollection('voice_notes');
        }

        if ($data['paid'] > 0) {
            $treatmentDetail->invoice()->create([
                "fees" => 0,
                "paid" => $data['paid'],
                "tooth" => $treatmentDetail->tooth,
                "treatment" => "Follow Up For Date : " . $treatmentDetail->updated_at->format("d-m-Y"),
                "tax_invoice" => $patient->need_invoice,
                'patient_id' => $patient->id,
                "treatment_detail_id" => $treatmentDetail->id,
                'doctor_id' => isset($data['doctor_id']) ? $data['doctor_id'] : auth()->id(),
            ]);
        }

        if ($data['lab']) {
            $lab = $data['lab'];
            $treatmentDetail->labOrder()->updateOrCreate([
                "treatment_detail_id" => $treatmentDetail->id
            ], [
                'work' => implode(" - ", $lab['work']),
                'cost' => isset($lab['cost']) ? $lab['cost'] : "",
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
