<?php

namespace App\Http\Services\Patient;

use App\Models\Patient;

class PatientProfileService extends PatientService
{
    public function boot(Patient $patient)
    {
        $distinctTeeth = $patient->treatmentSessions->sortDesc()->pluck('tooth')->unique()->values()->all();

        return $distinctTeeth;
    }
}
