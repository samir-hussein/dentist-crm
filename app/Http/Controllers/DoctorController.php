<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Interfaces\IDoctor;
use App\Http\Requests\Doctor\DoctorStoreRequest;
use App\Http\Requests\Doctor\DoctorUpdateRequest;

class DoctorController extends Controller
{
    private $service;

    public function __construct(IDoctor $doctorRepository)
    {
        $this->service = $doctorRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->service->all($request);

        return $this->view("doctor.index", ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->view("doctor.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DoctorStoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return $this->redirectWithSuccess("doctors.index");
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
    public function edit(User $doctor)
    {
        return $this->view("doctor.edit", ['data' => $doctor]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DoctorUpdateRequest $request, User $doctor)
    {
        $data = $request->validated();

        $this->service->update($doctor, $data);

        return $this->redirectWithSuccess("doctors.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $doctor)
    {
        $this->service->delete($doctor);
        return $this->redirectWithSuccess("doctors.index");
    }
}
