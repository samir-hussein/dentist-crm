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

        $voiceNoteUrl = $data->session->getFirstMediaUrl('voice_notes');

        $data->session->voiceNoteUrl = $voiceNoteUrl;

        $data->treatments = DiagnosisTreatment::where("diagnosis_id", $data->session->diagnose_id)
            ->whereHas('treatmentType', function ($q) use ($data) {
                $q->where("tooth_type", $data->session->tooth_type);
            })
            ->with([
                'treatmentType',
                'treatmentType.sections',
                'treatmentType.sections.attributes',
                // Filter inputs to only include those with the specified tooth
                'treatmentType.sections.attributes.inputs' => function ($inputQuery) use ($data) {
                    if ($data->session->tooth_type == "permanent") {
                        $inputQuery->where(function ($query) use ($data) {
                            foreach ($data->session->tooth as $tooth) {
                                $query->orWhereJsonContains('adultTooths', $tooth);
                            }
                        });
                    } else {
                        $inputQuery->where(function ($query) use ($data) {
                            foreach ($data->session->tooth as $tooth) {
                                $query->orWhereJsonContains('childTooths', $tooth);
                            }
                        });
                    }
                }
            ])
            ->get();

        $data->active_tab = explode(" - ", $data->session->treatment);
        $data->active_tab = end($data->active_tab);

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

        $panorama = $patient->getMedia(implode("-", $data->session->tooth))->sortByDesc('created_at')->map(function ($media) {
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
