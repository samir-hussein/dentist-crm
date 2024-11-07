<?php

namespace App\Http\Repositories;

use Illuminate\Http\Request;
use App\Http\Interfaces\ILabOrder;
use App\Http\Services\LabOrder\LabOrderIndexService;
use App\Http\Services\LabOrder\LabOrderUpdateService;
use App\Models\LabOrder;

class LabOrderRepository implements ILabOrder
{
    private $indexService;
    private $updateService;

    public function __construct(
        LabOrderIndexService $indexService,
        LabOrderUpdateService $updateService,
    ) {
        $this->indexService = $indexService;
        $this->updateService = $updateService;
    }

    public function index()
    {
        return $this->indexService->boot();
    }

    public function update(LabOrder $labOrder, array $data)
    {
        return $this->updateService->boot($labOrder, $data);
    }
}
