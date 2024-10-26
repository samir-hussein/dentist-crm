<?php

namespace App\Http\Repositories;

use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Interfaces\ITreatmentSession;
use App\Http\Services\TreatmentSession\TreatmentSessionTabsService;
use App\Http\Services\TreatmentSession\TreatmentSessionStartService;
use App\Http\Services\TreatmentSession\TreatmentSessionToothPanoramaService;

class TreatmentSessionRepository implements ITreatmentSession
{
    private $startService;
    private $tabsService;
    private $toothPanoramaService;

    public function __construct(
        TreatmentSessionStartService $startService,
        TreatmentSessionTabsService $tabsService,
        TreatmentSessionToothPanoramaService $toothPanoramaService
    ) {
        $this->startService = $startService;
        $this->tabsService = $tabsService;
        $this->toothPanoramaService = $toothPanoramaService;
    }

    public function start(Appointment $appointment)
    {
        return $this->startService->boot($appointment);
    }

    public function tabs(array $data)
    {
        return $this->tabsService->boot($data);
    }

    public function toothPanorama(Patient $patient, string $toothNumber)
    {
        return $this->toothPanoramaService->boot($patient, $toothNumber);
    }
}
