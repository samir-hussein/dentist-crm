<?php

namespace App\Http\Services\Patient;

use App\Models\Patient;

class PatientUpdateService extends PatientService
{
    public function boot(Patient $patient, array $data)
    {
        if (isset($data['medical_history']) && count($data['medical_history']) > 0) {
            $data['medical_history'] = implode(" - ", $data['medical_history']);
        }

        $patient->update($data);

        return $this->success();
    }
}
