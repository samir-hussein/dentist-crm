<?php

namespace App\Http\Services\TreatmentSession;

use App\Models\Patient;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PanoramaDeleteService extends TreatmentSessionService
{
    public function boot(Patient $patient, int $id)
    {
        Media::where("id", $id)->delete();

        $panorama = $patient->getMedia("panorama")->sortByDesc('created_at')->map(function ($media) {
            return [
                "id" => $media->id,
                "url" => $media->getUrl()
            ];
        });

        $slider = view("ajax-components.panorama-slider", ['panorama' => $panorama])->render();
        $modals = view("ajax-components.panorama-modals", ['panorama' => $panorama])->render();

        return [
            "slider" => $slider,
            "modals" => $modals
        ];
    }
}
