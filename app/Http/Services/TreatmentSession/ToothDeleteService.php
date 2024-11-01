<?php

namespace App\Http\Services\TreatmentSession;

use App\Models\Patient;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ToothDeleteService extends TreatmentSessionService
{
    public function boot(Patient $patient, int $id, string $toothNumber)
    {
        Media::where("id", $id)->delete();

        $panorama = $patient->getMedia($toothNumber)->sortByDesc('created_at')->map(function ($media) {
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
