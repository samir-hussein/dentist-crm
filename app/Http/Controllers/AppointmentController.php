<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\IAppointment;
use App\Http\Requests\Appointment\AppointmentStoreRequest;
use App\Http\Requests\Appointment\AppointmentUpdateRequest;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    private $service;

    public function __construct(IAppointment $appointmentRepository)
    {
        $this->service = $appointmentRepository;
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
     * Get a listing of the resource.
     */
    public function profile(Appointment $appointment)
    {
        return $appointment;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->view('appointment.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->view("appointment.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AppointmentStoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return $this->redirectWithSuccess("appointments.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        $data = $this->service->findById($appointment);

        return $this->view("appointment.edit", ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AppointmentUpdateRequest $request, Appointment $appointment)
    {
        $data = $request->validated();

        $this->service->update($appointment, $data);

        return $this->backWithSuccess();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $this->service->delete($appointment);
        return $this->redirectWithSuccess("appointments.index");
    }

    public function markCompleted(Appointment $appointment)
    {
        $this->service->markCompleted($appointment);
        return $this->redirectWithSuccess("appointments.index");
    }
}
