<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\IMedicalHistory;
use App\Http\Requests\MedicalHistory\MedicalHistoryStoreRequest;
use App\Http\Requests\MedicalHistory\MedicalHistoryUpdateRequest;
use App\Models\MedicalHistory;
use Illuminate\Http\Request;

class MedicalHistoryController extends Controller
{
    private $service;

    public function __construct(IMedicalHistory $medicalHistoryRepository)
    {
        $this->service = $medicalHistoryRepository;
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
        return $this->view("medical-history.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->view("medical-history.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicalHistoryStoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return $this->redirectWithSuccess("medical-histories.index");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MedicalHistory $medicalHistory)
    {
        $data = $this->service->findById($medicalHistory);

        return $this->view("medical-history.edit", ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MedicalHistoryUpdateRequest $request, MedicalHistory $medicalHistory)
    {
        $data = $request->validated();

        $this->service->update($medicalHistory, $data);

        return $this->redirectWithSuccess("medical-histories.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicalHistory $medicalHistory)
    {
        $this->service->delete($medicalHistory);
        return $this->redirectWithSuccess("medical-histories.index");
    }
}
