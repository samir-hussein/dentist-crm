<?php

namespace App\Http\Services\TreatmentSession;

use App\Models\Patient;

class PanoramaUploadFilesService extends TreatmentSessionService
{
    public function boot(Patient $patient, array $data)
    {
        $files = $data['panorama_files'];

        foreach ($files as $file) {
            $patient->addMedia($file)->toMediaCollection('panorama');
        }

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
