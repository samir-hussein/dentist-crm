<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\IMedicineType;
use App\Http\Requests\MedicineType\MedicineTypeStoreRequest;
use App\Http\Requests\MedicineType\MedicineTypeUpdateRequest;
use App\Models\MedicineType;
use Illuminate\Http\Request;

class MedicineTypeController extends Controller
{
    private $service;

    public function __construct(IMedicineType $medicineTypeRepository)
    {
        $this->service = $medicineTypeRepository;
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
        return $this->view("medicine-type.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->view("medicine-type.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicineTypeStoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return $this->redirectWithSuccess("medicine-types.index");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MedicineType $medicineType)
    {
        $data = $this->service->findById($medicineType);

        return $this->view("medicine-type.edit", ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MedicineTypeUpdateRequest $request, MedicineType $medicineType)
    {
        $data = $request->validated();

        $this->service->update($medicineType, $data);

        return $this->redirectWithSuccess("medicine-types.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicineType $medicineType)
    {
        $this->service->delete($medicineType);
        return $this->redirectWithSuccess("medicine-types.index");
    }
}
