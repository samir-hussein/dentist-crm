<?php

namespace App\Http\Repositories;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Interfaces\ITreatmentSession;
use App\Http\Services\TreatmentSession\ToothDeleteService;
use App\Http\Services\TreatmentSession\PanoramaDeleteService;
use App\Http\Services\TreatmentSession\ToothUploadFilesService;
use App\Http\Services\TreatmentSession\PanoramaUploadFilesService;
use App\Http\Services\TreatmentSession\TreatmentSessionTabsService;
use App\Http\Services\TreatmentSession\TreatmentSessionStartService;
use App\Http\Services\TreatmentSession\TreatmentSessionToothPanoramaService;

class TreatmentSessionRepository implements ITreatmentSession
{
    private $startService;
    private $tabsService;
    private $toothPanoramaService;
    private $panoramaUploadFilesService;
    private $panoramaDeleteService;
    private $toothUploadFilesService;
    private $toothDeleteService;

    public function __construct(
        TreatmentSessionStartService $startService,
        TreatmentSessionTabsService $tabsService,
        TreatmentSessionToothPanoramaService $toothPanoramaService,
        PanoramaUploadFilesService $panoramaUploadFilesService,
        PanoramaDeleteService $panoramaDeleteService,
        ToothUploadFilesService $toothUploadFilesService,
        ToothDeleteService $toothDeleteService
    ) {
        $this->startService = $startService;
        $this->tabsService = $tabsService;
        $this->toothPanoramaService = $toothPanoramaService;
        $this->panoramaUploadFilesService = $panoramaUploadFilesService;
        $this->panoramaDeleteService = $panoramaDeleteService;
        $this->toothUploadFilesService = $toothUploadFilesService;
        $this->toothDeleteService = $toothDeleteService;
    }

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
}
