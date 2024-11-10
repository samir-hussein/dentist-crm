<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\IService;
use App\Http\Requests\Service\ServiceStoreRequest;
use App\Http\Requests\Service\ServiceUpdateRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    private $service;

    public function __construct(IService $serviceRepository)
    {
        $this->service = $serviceRepository;
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
        return $this->view("service.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->view("service.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceStoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return $this->redirectWithSuccess("services.index");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        $data = $this->service->findById($service);

        return $this->view("service.edit", ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceUpdateRequest $request, Service $service)
    {
        $data = $request->validated();

        $this->service->update($service, $data);

        return $this->redirectWithSuccess("services.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $this->service->delete($service);
        return $this->redirectWithSuccess("services.index");
    }
}
