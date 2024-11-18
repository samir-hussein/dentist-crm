<?php

namespace App\Http\Services\Patient;

class PatientListService extends PatientService
{
    public function boot()
    {
        $data = $this->model
            ->with([
                'labOrder',
                'labOrder.lab',
                'latestTreatmentSession'
            ])
            ->get(['id', 'name', 'phone', 'phone2', 'code'])
            ->map(function ($patient) {
                if ($patient->labOrder) {
                    $patient->labOrder->name = $patient->labOrder->lab->name;
                    $patient->labOrder->sentFormated = $patient->labOrder->sent?->format('d-m-Y');
                    $patient->labOrder->receivedFormated = $patient->labOrder->received?->format('d-m-Y');
                }
                // Extract updated_at from the last treatment session if it exists
                $patient->lastTreatmentUpdated = $patient->latestTreatmentSession?->updated_at?->format('d-m-Y');
                unset($patient->latestTreatmentSession);
                return $patient;
            });

        return $data;
    }
}
