<?php

namespace App\Http\Services\Patient;

use App\Models\Patient;

class PatientDeleteService extends PatientService
{
    public function boot(Patient $patient)
    {
        $patient->delete();

        return $this->success();
    }
}
