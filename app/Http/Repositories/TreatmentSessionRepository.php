<?php

namespace App\Http\Repositories;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Interfaces\ITreatmentSession;
use App\Http\Services\TreatmentSession\TreatmentSessionTabsService;
use App\Http\Services\TreatmentSession\TreatmentSessionStartService;

class TreatmentSessionRepository implements ITreatmentSession
{
    private $startService;
    private $tabsService;

    public function __construct(
        TreatmentSessionStartService $startService,
        TreatmentSessionTabsService $tabsService,
    ) {
        $this->startService = $startService;
        $this->tabsService = $tabsService;
    }

    public function start(Appointment $appointment)
    {
        return $this->startService->boot($appointment);
    }

    public function tabs(array $data)
    {
        return $this->tabsService->boot($data);
    }
}
