<?php

namespace App\Http\Services\TreatmentSession;

use stdClass;
use App\Models\Lab;
use App\Models\Dose;
use App\Models\Diagnosis;
use App\Models\LabService;
use App\Models\MedicineType;
use App\Models\DiagnosisTreatment;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;

class TreatmentSessionShowByIdService extends TreatmentSessionService
{
    public function boot(Model $model, Patient $patient)
    {
        $data = new stdClass;

        $data->session = $model->load(['diagnose', 'invoice', 'labOrder']);

        $data->treatments = DiagnosisTreatment::where("diagnosis_id", $data->session->diagnose_id)->with(['treatmentType', 'treatmentType.sections', 'treatmentType.sections.attributes', 'treatmentType.sections.attributes.inputs' => function ($q) use ($data) {
            $q->whereJsonContains('adultTooths', $data->session->tooth)
                ->orWhereJsonContains('childTooths', $data->session->tooth);
        }])->get();

        $data->labs = Lab::all();
        $data->labsServices = LabService::all();

        $data->patient = $patient;
        $data->panorama = $patient->getMedia('panorama')->sortByDesc('created_at')->map(function ($media) {
            return [
                "id" => $media->id,
                "url" => $media->getUrl()
            ];
        });

        $data->medicines = MedicineType::with('medicines')->get()->map(function ($row) {
            $row->medicine = $row->medicines->pluck('name'); // Use pluck to directly get an array of names
            unset($row->medicines);
            return $row;
        });

        $data->doses = Dose::pluck("dose");

        unset($data->patient->media);

        $panorama = $patient->getMedia($data->session->tooth)->sortByDesc('created_at')->map(function ($media) {
            return [
                "id" => $media->id,
                "url" => $media->getUrl()
            ];
        });

        $data->tooth = new stdClass;

        $data->tooth->slider = view("ajax-components.tooth-panorama-slider", ['panorama' => $panorama])->render();
        $data->tooth->modals = view("ajax-components.tooth-panorama-modals", ['panorama' => $panorama])->render();

        return $data;
    }
}
