<?php

namespace App\Http\Controllers;

use App\Models\SchduleDay;
use App\Models\SchduleDate;
use Illuminate\Http\Request;
use App\Http\Interfaces\ISchduleDate;
use App\Http\Requests\TimeUpdateRequest;
use App\Http\Requests\SchduleDay\SchduleDayStoreRequest;
use App\Http\Requests\SchduleDay\SchduleDayUpdateRequest;

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
    public function show(SchduleDate $schduleDate)
    {
        $data = $this->service->findById($schduleDate);

        return $this->view("schdule-date.show", ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TimeUpdateRequest $request, int $appointmentId)
    {
        $data = $request->validated();

        $this->service->update($appointmentId, $data);

        return $this->redirectWithSuccess("schdule-days.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function makeHoliday(SchduleDate $schduleDate)
    {
        $this->service->makeHoliday($schduleDate);
        return $this->redirectWithSuccess("schdule-dates.index");
    }

    public function destroy(int $appointmentId)
    {
        $this->service->destroyAppointment($appointmentId);

        return $this->backWithSuccess();
    }
}
