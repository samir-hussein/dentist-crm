<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\IAssistant;
use Illuminate\Http\Request;
use App\Http\Interfaces\IShift;
use App\Http\Requests\Shift\ShiftStoreRequest;

class ShiftController extends Controller
{
    private $service;

    public function __construct(IShift $shiftRepository, private IAssistant $assistantService)
    {
        $this->service = $shiftRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->service->all($request);

        return $this->view("assistant.shift", [
            'shifts' => $data['shifts'],
            'daysInMonth' => $data['daysInMonth'],
            'month' => $data['month'],
            'year' => $data['year'],
            'assistants' => $this->assistantService->listService(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShiftStoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return $this->redirectWithSuccess("home");
    }
}
