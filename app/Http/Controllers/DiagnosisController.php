<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\IDiagnosis;
use App\Http\Requests\Diagnosis\DiagnosisStoreRequest;
use App\Http\Requests\Diagnosis\DiagnosisUpdateRequest;
use App\Models\Diagnosis;
use Illuminate\Http\Request;

class DiagnosisController extends Controller
{
    private $service;

    public function __construct(IDiagnosis $diagnosisRepository)
    {
        $this->service = $diagnosisRepository;
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
    public function profile(Diagnosis $diagnosis)
    {
        return $diagnosis;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->view('diagnosis.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->view("diagnosis.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DiagnosisStoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return $this->redirectWithSuccess("diagnosis.index");
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
    public function edit(int $diagnosis)
    {
        $data = $this->service->findById($diagnosis);

        return $this->view("diagnosis.edit", ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DiagnosisUpdateRequest $request, int $diagnosis)
    {
        $data = $request->validated();

        $this->service->update($diagnosis, $data);

        return $this->backWithSuccess();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $diagnosis)
    {
        $this->service->delete($diagnosis);
        return $this->redirectWithSuccess("diagnosis.index");
    }
}
