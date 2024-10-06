<?php

namespace App\Http\Repositories;

use App\Models\Lab;
use Illuminate\Http\Request;
use App\Http\Interfaces\ILab;
use App\Http\Services\Lab\LabStoreService;
use App\Http\Services\Lab\LabDeleteService;
use App\Http\Services\Lab\LabGetAllService;
use App\Http\Services\Lab\LabUpdateService;
use App\Http\Services\Lab\LabFindByIdService;

class LabRepository implements ILab
{
    private $labGetAllService;
    private $labStoreService;
    private $labDeleteService;
    private $labFindById;
    private $labUpdateService;

    public function __construct(
        LabGetAllService $labGetAllService,
        LabStoreService $labStoreService,
        LabDeleteService $labDeleteService,
        LabFindByIdService $labFindById,
        LabUpdateService $labUpdateService
    ) {
        $this->labGetAllService = $labGetAllService;
        $this->labStoreService = $labStoreService;
        $this->labDeleteService = $labDeleteService;
        $this->labFindById = $labFindById;
        $this->labUpdateService = $labUpdateService;
    }

    public function all(Request $request)
    {
        return $this->labGetAllService->boot($request);
    }

    public function findById(Lab $lab)
    {
        return $this->labFindById->boot($lab);
    }

    public function store(array $data)
    {
        return $this->labStoreService->boot($data);
    }

    public function update(Lab $lab, array $data)
    {
        return $this->labUpdateService->boot($lab, $data);
    }

    public function delete(Lab $lab)
    {
        return $this->labDeleteService->boot($lab);
    }
}
