<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\IDose;
use App\Http\Requests\Dose\DoseStoreRequest;
use App\Http\Requests\Dose\DoseUpdateRequest;
use App\Models\Dose;
use Illuminate\Http\Request;

class DoseController extends Controller
{
    private $service;

    public function __construct(IDose $doseRepository)
    {
        $this->service = $doseRepository;
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
        return $this->view("dose.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->view("dose.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DoseStoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return $this->redirectWithSuccess("doses.index");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dose $dose)
    {
        $data = $this->service->findById($dose);

        return $this->view("dose.edit", ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DoseUpdateRequest $request, Dose $dose)
    {
        $data = $request->validated();

        $this->service->update($dose, $data);

        return $this->backWithSuccess();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dose $dose)
    {
        $this->service->delete($dose);
        return $this->redirectWithSuccess("doses.index");
    }
}
