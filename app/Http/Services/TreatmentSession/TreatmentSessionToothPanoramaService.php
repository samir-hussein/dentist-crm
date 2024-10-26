<?php

namespace App\Http\Services\TreatmentSession;

use App\Models\Patient;

class TreatmentSessionToothPanoramaService extends TreatmentSessionService
{
    public function boot(Patient $patient, string $toothNumber)
    {
        $panorama = $patient->getMedia($toothNumber)->map(function ($media) {
            return [
                "id" => $media->id,
                "url" => $media->getUrl()
            ];
        });

        $slider = view("ajax-components.tooth-panorama-slider", ['panorama' => $panorama])->render();
        $modals = view("ajax-components.tooth-panorama-modals", ['panorama' => $panorama])->render();

        return [
            "slider" => $slider,
            "modals" => $modals
        ];
    }
}
