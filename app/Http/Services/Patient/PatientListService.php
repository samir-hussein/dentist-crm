<?php

namespace App\Http\Services\Patient;

class PatientListService extends PatientService
{
    public function boot()
    {
        $data = $this->model->with(['labOrder', 'labOrder.lab'])->get(['id', 'name', 'phone', 'phone2', 'code'])->map(function ($patient) {
            if ($patient->labOrder) {
                $patient->labOrder->name = $patient->labOrder->lab->name;
                $patient->labOrder->sentFormated = $patient->labOrder->sent?->format('d-m-Y');
                $patient->labOrder->receivedFormated = $patient->labOrder->received?->format('d-m-Y');
            }
            return $patient;
        });

        return $data;
    }
}
