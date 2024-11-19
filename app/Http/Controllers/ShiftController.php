<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Interfaces\IShift;
use App\Http\Requests\Shift\ShiftStoreRequest;

class ShiftController extends Controller
{
    private $service;

    public function __construct(IShift $shiftRepository)
    {
        $this->service = $shiftRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, int $assistant_id)
    {
        $data = $this->service->all($request, $assistant_id);

        return $this->view("assistant.shift", [
            'shifts' => $data['shifts'],
            'daysInMonth' => $data['daysInMonth'],
            'month' => $data['month'],
            'year' => $data['year'],
            'assistant' => $data['assistant'],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShiftStoreRequest $request, int $assistant_id)
    {
        $data = $request->validated();

        $this->service->store($data, $assistant_id);

        return $this->redirectWithSuccess("assistants.index");
    }
}
