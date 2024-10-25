<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\ITreatmentSession;
use App\Http\Requests\TreatmentSession\TreatmentTabsRequest;
use App\Models\Appointment;
use Illuminate\Http\Request;

class TreatmentSessionController extends Controller
{
    private $service;

    public function __construct(ITreatmentSession $treatmentSessionRepository)
    {
        $this->service = $treatmentSessionRepository;
    }

    public function index(Appointment $appointment)
    {
        $data = $this->service->start($appointment);
        return view('treatment-session', ['data' => $data]);
    }

    public function getTreatmentTabs(TreatmentTabsRequest $request)
    {
        $data = $request->validated();

        $html = $this->service->tabs($data);

        return response()->json(['html' => $html]);
    }
}
