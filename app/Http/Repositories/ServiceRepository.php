<?php

namespace App\Http\Repositories;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Interfaces\IService;
use App\Http\Services\Service\ServiceStoreService;
use App\Http\Services\Service\ServiceDeleteService;
use App\Http\Services\Service\ServiceGetAllService;
use App\Http\Services\Service\ServiceUpdateService;
use App\Http\Services\Service\ServiceFindByIdService;

class ServiceRepository implements IService
{
    private $serviceGetAllService;
    private $serviceStoreService;
    private $serviceDeleteService;
    private $serviceFindById;
    private $serviceUpdate;

    public function __construct(
        ServiceGetAllService $serviceGetAllService,
        ServiceStoreService $serviceStoreService,
        ServiceDeleteService $serviceDeleteService,
        ServiceFindByIdService $serviceFindById,
        ServiceUpdateService $serviceUpdate
    ) {
        $this->serviceGetAllService = $serviceGetAllService;
        $this->serviceStoreService = $serviceStoreService;
        $this->serviceDeleteService = $serviceDeleteService;
        $this->serviceFindById = $serviceFindById;
        $this->serviceUpdate = $serviceUpdate;
    }

    public function all(Request $request)
    {
        return $this->serviceGetAllService->boot($request);
    }

    public function findById(Service $service)
    {
        return $this->serviceFindById->boot($service);
    }

    public function store(array $data)
    {
        return $this->serviceStoreService->boot($data);
    }

    public function update(Service $service, array $data)
    {
        return $this->serviceUpdate->boot($service, $data);
    }

    public function delete(Service $service)
    {
        return $this->serviceDeleteService->boot($service);
    }
}
