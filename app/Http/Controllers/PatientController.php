<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\IPatient;
use App\Http\Requests\Patient\PatientStoreRequest;
use App\Http\Requests\Patient\PatientUpdateRequest;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    private $service;

    public function __construct(IPatient $patientRepository)
    {
        $this->service = $patientRepository;
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
    public function profile(Patient $patient)
    {
        return $patient;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->view('patient.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->view("patient.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientStoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return $this->redirectWithSuccess("patients.index");
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
    public function edit(Patient $patient)
    {
        $data = $this->service->findById($patient);

        return $this->view("patient.edit", ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientUpdateRequest $request, Patient $patient)
    {
        $data = $request->validated();

        $this->service->update($patient, $data);

        return $this->backWithSuccess();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $this->service->delete($patient);
        return $this->redirectWithSuccess("patients.index");
    }
}
