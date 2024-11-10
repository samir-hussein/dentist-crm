<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\ILab;
use App\Http\Requests\Lab\LabStoreRequest;
use App\Http\Requests\Lab\LabUpdateRequest;
use App\Models\Lab;
use Illuminate\Http\Request;

class LabController extends Controller
{
    private $service;

    public function __construct(ILab $labRepository)
    {
        $this->service = $labRepository;
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
        return $this->view("lab.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->view("lab.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LabStoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return $this->redirectWithSuccess("labs.index");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lab $lab)
    {
        $data = $this->service->findById($lab);

        return $this->view("lab.edit", ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LabUpdateRequest $request, Lab $lab)
    {
        $data = $request->validated();

        $this->service->update($lab, $data);

        return $this->redirectWithSuccess("labs.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lab $lab)
    {
        $this->service->delete($lab);
        return $this->redirectWithSuccess("labs.index");
    }
}
