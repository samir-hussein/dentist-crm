<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Interfaces\ITreatmentSession;
use App\Http\Requests\TreatmentSession\TreatmentTabsRequest;
use App\Http\Requests\TreatmentSession\PanoramaUploadFilesRequest;

class TreatmentSessionController extends Controller
{
    private $service;

    public function __construct(ITreatmentSession $treatmentSessionRepository)
    {
        $this->service = $treatmentSessionRepository;
    }

    public function index(Patient $patient)
    {
        $data = $this->service->start($patient);
        return view('treatment-session', ['data' => $data]);
    }

    public function getTreatmentTabs(TreatmentTabsRequest $request)
    {
        $data = $request->validated();

        $html = $this->service->tabs($data);

        return response()->json(['html' => $html]);
    }

    public function getToothPanorama(Patient $patient, string $toothNumber)
    {
        $html = $this->service->toothPanorama($patient, $toothNumber);

        return response()->json(['html' => $html]);
    }

    public function panoramaUploadFiles(PanoramaUploadFilesRequest $request, Patient $patient)
    {
        $data = $request->validated();

        $html = $this->service->panoramaUploadFiles($patient, $data);

        return response()->json(['html' => $html]);
    }


    public function panoramaDelete(Patient $patient, int $id)
    {
        $html = $this->service->panoramaDelete($patient, $id);

        return response()->json(['html' => $html]);
    }

    public function toothUploadFiles(PanoramaUploadFilesRequest $request, Patient $patient, string $toothNumber)
    {
        $data = $request->validated();

        $html = $this->service->toothUploadFiles($patient, $data, $toothNumber);

        return response()->json(['html' => $html]);
    }


    public function toothDelete(Patient $patient, int $id, string $toothNumber)
    {
        $html = $this->service->toothDelete($patient, $id, $toothNumber);

        return response()->json(['html' => $html]);
    }
}
