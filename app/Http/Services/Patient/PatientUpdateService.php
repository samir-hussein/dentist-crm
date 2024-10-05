<?php

namespace App\Http\Services\Patient;

use App\Models\Patient;

class PatientUpdateService extends PatientService
{
    public function boot(Patient $patient, array $data)
    {
        $patient->update($data);

        return $this->success();
    }
}
