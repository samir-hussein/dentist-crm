<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\ISchduleDate;
use App\Http\Requests\SchduleDay\SchduleDayStoreRequest;
use App\Http\Requests\SchduleDay\SchduleDayUpdateRequest;
use App\Models\SchduleDate;
use App\Models\SchduleDay;
use Illuminate\Http\Request;

class SchduleDateController extends Controller
{
    private $service;

    public function __construct(ISchduleDate $schduleDateRepository)
    {
        $this->service = $schduleDateRepository;
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
        return $this->view("schdule-date.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->view("schdule-day.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SchduleDayStoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return $this->redirectWithSuccess("schdule-days.index");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchduleDate $schduleDay)
    {
        $data = $this->service->findById($schduleDay);

        return $this->view("schdule-day.edit", ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SchduleDayUpdateRequest $request, SchduleDate $schduleDay)
    {
        $data = $request->validated();

        $this->service->update($schduleDay, $data);

        return $this->backWithSuccess();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchduleDate $schduleDay)
    {
        $this->service->delete($schduleDay);
        return $this->redirectWithSuccess("schdule-days.index");
    }
}