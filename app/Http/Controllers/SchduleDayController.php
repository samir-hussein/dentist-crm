<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\IBranch;
use App\Http\Interfaces\IDoctor;
use App\Http\Interfaces\ISchduleDay;
use App\Http\Requests\SchduleDay\SchduleDayStoreRequest;
use App\Http\Requests\SchduleDay\SchduleDayUpdateRequest;
use App\Models\SchduleDay;
use Illuminate\Http\Request;

class SchduleDayController extends Controller
{
    private $service;

    public function __construct(ISchduleDay $schduleDayRepository, private IDoctor $doctorService, private IBranch $branchService)
    {
        $this->service = $schduleDayRepository;
    }

    /**
     * Get a listing of the resource.
     */
    public function all(Request $request)
    {
        $data = $this->service->all($request);

        return $data;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->view("schdule-day.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->view("schdule-day.create", [
            "doctors" => $this->doctorService->listService(),
            "branchs" => $this->branchService->listService()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SchduleDayStoreRequest $request)
    {
        $data = $request->validated();

        $response = $this->service->store($data);

        if ($response['status'] == "error") {
            return $this->backWithError($response['errors']);
        }

        return $this->redirectWithSuccess("schdule-days.index");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchduleDay $schduleDay)
    {
        $data = $this->service->findById($schduleDay);

        return $this->view("schdule-day.edit", [
            'data' => $data,
            "doctors" => $this->doctorService->listService(),
            "branchs" => $this->branchService->listService()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SchduleDayUpdateRequest $request, SchduleDay $schduleDay)
    {
        $data = $request->validated();

        $response = $this->service->update($schduleDay, $data);

        if ($response['status'] == "error") {
            return $this->backWithError($response['errors']);
        }

        return $this->redirectWithSuccess("schdule-days.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchduleDay $schduleDay)
    {
        $this->service->delete($schduleDay);
        return $this->redirectWithSuccess("schdule-days.index");
    }
}
