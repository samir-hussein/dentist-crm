<?php

namespace App\Http\Services\TreatmentSession;

use App\Models\Diagnosis;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class TreatmentSessionStartService extends TreatmentSessionService
{
    public function boot(Model $model)
    {
        $data = new stdClass;
        $data->appointment = $model->load(['patient']);
        $data->panorama = $data->appointment->patient->getMedia('panorama')->map(function ($media) {
            return [
                "id" => $media->id,
                "url" => $media->getUrl()
            ];
        });
        $data->diagnosis = Diagnosis::all();

        unset($data->appointment->patient->media);

        return $data;
    }
}
