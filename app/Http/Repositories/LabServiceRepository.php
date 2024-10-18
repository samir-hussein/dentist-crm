<?php

namespace App\Http\Repositories;

use App\Models\LabService;
use Illuminate\Http\Request;
use App\Http\Interfaces\ILabService;
use App\Http\Services\LabService\LabServiceStoreService;
use App\Http\Services\LabService\LabServiceDeleteService;
use App\Http\Services\LabService\LabServiceGetAllService;
use App\Http\Services\LabService\LabServiceUpdateService;
use App\Http\Services\LabService\LabServiceFindByIdService;

class LabServiceRepository implements ILabService
{
    private $labServiceGetAllService;
    private $labServiceStoreService;
    private $labServiceDeleteService;
    private $labServiceFindByIdService;
    private $labServiceUpdateService;

    public function __construct(
        LabServiceGetAllService $labServiceGetAllService,
        LabServiceStoreService $labServiceStoreService,
        LabServiceDeleteService $labServiceDeleteService,
        LabServiceFindByIdService $labServiceFindByIdService,
        LabServiceUpdateService $labServiceUpdateService,
    ) {
        $this->labServiceGetAllService = $labServiceGetAllService;
        $this->labServiceStoreService = $labServiceStoreService;
        $this->labServiceDeleteService = $labServiceDeleteService;
        $this->labServiceUpdateService = $labServiceUpdateService;
        $this->labServiceFindByIdService = $labServiceFindByIdService;
    }

    public function all(Request $request)
    {
        return $this->labServiceGetAllService->boot($request);
    }

    public function findById(LabService $labService)
    {
        return $this->labServiceFindByIdService->boot($labService);
    }

    public function store(array $data)
    {
        return $this->labServiceStoreService->boot($data);
    }

    public function update(LabService $labService, array $data)
    {
        return $this->labServiceUpdateService->boot($labService, $data);
    }

    public function delete(LabService $labService)
    {
        return $this->labServiceDeleteService->boot($labService);
    }
}
