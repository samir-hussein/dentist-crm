<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\IDoctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Interfaces\ITreatmentSession;
use App\Http\Requests\TreatmentSession\DentalHistoryStoreRequest;
use App\Http\Requests\TreatmentSession\TreatmentTabsRequest;
use App\Http\Requests\TreatmentSession\PanoramaUploadFilesRequest;
use App\Http\Requests\TreatmentSession\TreatmentSessionStoreRequest;
use App\Http\Requests\TreatmentSession\TreatmentSessionUpdateRequest;
use App\Models\TreatmentDetail;

class TreatmentSessionController extends Controller
{
    private $service;

    public function __construct(ITreatmentSession $treatmentSessionRepository, private IDoctor $doctorService)
    {
        $this->service = $treatmentSessionRepository;
    }

    public function index(Patient $patient)
    {
        $data = $this->service->start($patient);
        return view('treatment-session.create', ['data' => $data]);
    }

    public function dentalHistory(Patient $patient)
    {
        $data = $this->service->start($patient);
        return view('treatment-session.dental-history', ['data' => $data, 'doctors' => $this->doctorService->listService()]);
    }

    public function getAll(Request $request)
    {
        $data = $this->service->getAll($request);
        return $data;
    }

    public function edit(TreatmentDetail $treatmentDetail, Patient $patient)
    {
        $data = $this->service->showById($treatmentDetail, $patient);

        return view('treatment-session.edit', ['data' => $data, 'treatments' => $data->treatments, 'labs' => $data->labs, 'labsServices' => $data->labsServices]);
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

    public function storeTreatmentSession(TreatmentSessionStoreRequest $request, Patient $patient)
    {
        $data = $request->validated();

        return $this->service->storeTreatmentSession($patient, $data);
    }

    public function storeDentalHistory(DentalHistoryStoreRequest $request, Patient $patient)
    {
        $data = $request->validated();

        return $this->service->storeDentalHistory($patient, $data);
    }

    public function update(TreatmentSessionUpdateRequest $request, TreatmentDetail $treatmentDetail, Patient $patient)
    {
        $data = $request->validated();

        return $this->service->updateTreatmentSession($treatmentDetail, $patient, $data);
    }
}
