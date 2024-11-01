<?php

namespace App\Http\Services\TreatmentSession;

use stdClass;
use App\Models\Dose;
use App\Models\Diagnosis;
use App\Models\MedicineType;
use Illuminate\Database\Eloquent\Model;

class TreatmentSessionStartService extends TreatmentSessionService
{
    public function boot(Model $model)
    {
        $data = new stdClass;
        $data->patient = $model;
        $data->panorama = $data->patient->getMedia('panorama')->sortByDesc('created_at')->map(function ($media) {
            return [
                "id" => $media->id,
                "url" => $media->getUrl()
            ];
        });

        $data->diagnosis = Diagnosis::all();

        $data->medicines = MedicineType::with('medicines')->get()->map(function ($row) {
            $row->medicine = $row->medicines->pluck('name'); // Use pluck to directly get an array of names
            unset($row->medicines);
            return $row;
        });

        $data->doses = Dose::pluck("dose");

        unset($data->patient->media);

        return $data;
    }
}
