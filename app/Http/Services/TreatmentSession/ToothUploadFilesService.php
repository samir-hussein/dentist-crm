<?php

namespace App\Http\Services\TreatmentSession;

use App\Models\Patient;

class ToothUploadFilesService extends TreatmentSessionService
{
    public function boot(Patient $patient, array $data, string $toothNumber)
    {
        $files = $data['panorama_files'];

        foreach ($files as $file) {
            $patient->addMedia($file)->toMediaCollection($toothNumber);
        }

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
