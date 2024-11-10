<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\IMedicine;
use App\Http\Requests\Medicine\MedicineStoreRequest;
use App\Http\Requests\Medicine\MedicineUpdateRequest;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    private $service;

    public function __construct(IMedicine $medicineRepository)
    {
        $this->service = $medicineRepository;
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
        return $this->view('medicine.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = $this->service->necessaryData();
        return $this->view("medicine.create", ['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicineStoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return $this->redirectWithSuccess("medicines.index");
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
    public function edit(Medicine $medicine)
    {
        $data = $this->service->findById($medicine);

        return $this->view("medicine.edit", ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MedicineUpdateRequest $request, Medicine $medicine)
    {
        $data = $request->validated();

        $this->service->update($medicine, $data);

        return $this->redirectWithSuccess("medicines.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medicine $medicine)
    {
        $this->service->delete($medicine);
        return $this->redirectWithSuccess("medicines.index");
    }
}
