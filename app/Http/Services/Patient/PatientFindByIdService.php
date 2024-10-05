<?php

namespace App\Http\Services\Patient;

use App\Models\Patient;

class PatientFindByIdService extends PatientService
{
    public function boot(Patient $patient)
    {
        return $patient;
    }
}
