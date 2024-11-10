<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\ISchduleDay;
use App\Http\Requests\SchduleDay\SchduleDayStoreRequest;
use App\Http\Requests\SchduleDay\SchduleDayUpdateRequest;
use App\Models\SchduleDay;
use Illuminate\Http\Request;

class SchduleDayController extends Controller
{
    private $service;

    public function __construct(ISchduleDay $schduleDayRepository)
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
    public function edit(SchduleDay $schduleDay)
    {
        $data = $this->service->findById($schduleDay);

        return $this->view("schdule-day.edit", ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SchduleDayUpdateRequest $request, SchduleDay $schduleDay)
    {
        $data = $request->validated();

        $this->service->update($schduleDay, $data);

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
