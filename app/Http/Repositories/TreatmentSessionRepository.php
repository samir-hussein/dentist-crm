<?php

namespace App\Http\Repositories;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\TreatmentDetail;
use App\Http\Interfaces\ITreatmentSession;
use App\Http\Services\TreatmentSession\DentalHistoryStoreService;
use App\Http\Services\TreatmentSession\ToothDeleteService;
use App\Http\Services\TreatmentSession\PanoramaDeleteService;
use App\Http\Services\TreatmentSession\ToothUploadFilesService;
use App\Http\Services\TreatmentSession\PanoramaUploadFilesService;
use App\Http\Services\TreatmentSession\TreatmentSessionDeleteService;
use App\Http\Services\TreatmentSession\TreatmentSessionTabsService;
use App\Http\Services\TreatmentSession\TreatmentSessionStartService;
use App\Http\Services\TreatmentSession\TreatmentSessionStoreService;
use App\Http\Services\TreatmentSession\TreatmentSessionGetAllService;
use App\Http\Services\TreatmentSession\TreatmentSessionUpdateService;
use App\Http\Services\TreatmentSession\TreatmentSessionShowByIdService;
use App\Http\Services\TreatmentSession\TreatmentSessionToothPanoramaService;

class TreatmentSessionRepository implements ITreatmentSession
{
    public function __construct(
        private TreatmentSessionStartService $startService,
        private TreatmentSessionTabsService $tabsService,
        private TreatmentSessionToothPanoramaService $toothPanoramaService,
        private PanoramaUploadFilesService $panoramaUploadFilesService,
        private PanoramaDeleteService $panoramaDeleteService,
        private ToothUploadFilesService $toothUploadFilesService,
        private ToothDeleteService $toothDeleteService,
        private TreatmentSessionStoreService $treatmentSessionStoreService,
        private TreatmentSessionShowByIdService $treatmentSessionShowByIdService,
        private TreatmentSessionUpdateService $treatmentSessionUpdateService,
        private TreatmentSessionGetAllService $treatmentSessionGetAllService,
        private DentalHistoryStoreService $dentalHistoryStoreService,
        private TreatmentSessionDeleteService $treatmentSessionDeleteService
    ) {}

    public function start(Patient $patient)
    {
        return $this->startService->boot($patient);
    }

    public function tabs(array $data)
    {
        return $this->tabsService->boot($data);
    }

    public function toothPanorama(Patient $patient, string $toothNumber)
    {
        return $this->toothPanoramaService->boot($patient, $toothNumber);
    }

    public function panoramaUploadFiles(Patient $patient, array $data)
    {
        return $this->panoramaUploadFilesService->boot($patient, $data);
    }

    public function destroy(TreatmentDetail $treatmentDetail)
    {
        return $this->treatmentSessionDeleteService->boot($treatmentDetail);
    }

    public function panoramaDelete(Patient $patient, int $id)
    {
        return $this->panoramaDeleteService->boot($patient, $id);
    }

    public function toothUploadFiles(Patient $patient, array $data, string $toothNumber)
    {
        return $this->toothUploadFilesService->boot($patient, $data, $toothNumber);
    }

    public function toothDelete(Patient $patient, int $id, string $toothNumber)
    {
        return $this->toothDeleteService->boot($patient, $id, $toothNumber);
    }

    public function storeTreatmentSession(Patient $patient, array $data)
    {
        return $this->treatmentSessionStoreService->boot($patient, $data);
    }

    public function storeDentalHistory(Patient $patient, array $data)
    {
        return $this->dentalHistoryStoreService->boot($patient, $data);
    }

    public function showById(TreatmentDetail $treatmentDetail, Patient $patient)
    {
        return $this->treatmentSessionShowByIdService->boot($treatmentDetail, $patient);
    }

    public function updateTreatmentSession(TreatmentDetail $treatmentDetail, Patient $patient, array $data)
    {
        return $this->treatmentSessionUpdateService->boot($treatmentDetail, $patient, $data);
    }

    public function getAll(Request $request)
    {
        return $this->treatmentSessionGetAllService->boot($request);
    }
}
