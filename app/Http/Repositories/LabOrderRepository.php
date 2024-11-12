<?php

namespace App\Http\Repositories;

use Illuminate\Http\Request;
use App\Http\Interfaces\ILabOrder;
use App\Http\Services\LabOrder\LabOrderIndexService;
use App\Http\Services\LabOrder\LabOrderReportService;
use App\Http\Services\LabOrder\LabOrderUpdateService;
use App\Models\LabOrder;

class LabOrderRepository implements ILabOrder
{
    private $indexService;
    private $updateService;
    private $reportService;

    public function __construct(
        LabOrderIndexService $indexService,
        LabOrderUpdateService $updateService,
        LabOrderReportService $reportService
    ) {
        $this->indexService = $indexService;
        $this->updateService = $updateService;
        $this->reportService = $reportService;
    }

    public function index()
    {
        return $this->indexService->boot();
    }

    public function report()
    {
        return $this->reportService->boot();
    }

    public function update(LabOrder $labOrder, array $data)
    {
        return $this->updateService->boot($labOrder, $data);
    }
}
