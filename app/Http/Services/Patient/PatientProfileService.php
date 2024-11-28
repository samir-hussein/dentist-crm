<?php

namespace App\Http\Services\Patient;

use App\Models\Patient;

class PatientProfileService extends PatientService
{
    public function boot(Patient $patient)
    {
        $distinctTeeth = $patient->treatmentSessions
            ->sortDesc()
            ->pluck('tooth')  // Get all 'tooth' values (which are now arrays)
            ->flatten()       // Flatten the array of arrays into a single array
            ->unique()        // Get distinct tooth numbers
            ->values()        // Re-index the array to get consecutive indices
            ->all();

        $panorama = $patient->getMedia('panorama')->sortByDesc('created_at')->map(function ($media) {
            return [
                "id" => $media->id,
                "url" => $media->getUrl()
            ];
        });

        return [
            "distinctTeeth" => $distinctTeeth,
            "panorama" => $panorama,
        ];
    }
}
