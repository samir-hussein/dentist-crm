<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\ILabService;
use App\Http\Requests\LabService\LabServiceStoreRequest;
use App\Http\Requests\LabService\LabServiceUpdateRequest;
use App\Models\LabService;
use Illuminate\Http\Request;

class LabServiceController extends Controller
{
    private $service;

    public function __construct(ILabService $labServiceRepository)
    {
        $this->service = $labServiceRepository;
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
        return $this->view("lab-service.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->view("lab-service.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LabServiceStoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return $this->redirectWithSuccess("lab-services.index");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LabService $labService)
    {
        $data = $this->service->findById($labService);

        return $this->view("lab-service.edit", ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LabServiceUpdateRequest $request, LabService $labService)
    {
        $data = $request->validated();

        $this->service->update($labService, $data);

        return $this->redirectWithSuccess("lab-services.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LabService $labService)
    {
        $this->service->delete($labService);
        return $this->redirectWithSuccess("lab-services.index");
    }
}
