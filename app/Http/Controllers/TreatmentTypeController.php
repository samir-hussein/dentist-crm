<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\ITrearmentType;
use App\Http\Requests\TreatmentType\TreatmentTypeStoreRequest;
use App\Models\TreatmentType;
use Illuminate\Http\Request;

class TreatmentTypeController extends Controller
{
    private $service;

    public function __construct(ITrearmentType $treatmentTypeRepository)
    {
        $this->service = $treatmentTypeRepository;
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
    public function profile(TreatmentType $treatmentType)
    {
        return $treatmentType;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->view('treatmentType.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = $this->service->necessaryData();
        return $this->view("treatmentType.create", ['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TreatmentTypeStoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return $this->redirectWithSuccess("treatment-types.index");
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
    public function edit(TreatmentType $treatmentType)
    {
        $data = $this->service->findById($treatmentType);

        return $this->view("treatmentType.edit", ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TreatmentTypeStoreRequest $request, TreatmentType $treatmentType)
    {
        $data = $request->validated();

        $this->service->update($treatmentType, $data);

        return $this->backWithSuccess();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TreatmentType $treatmentType)
    {
        $this->service->delete($treatmentType);
        return $this->redirectWithSuccess("treatment-types.index");
    }
}
