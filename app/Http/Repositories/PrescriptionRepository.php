<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\IPrescription;
use App\Http\Services\Prescription\PrescriptionIndexService;

class PrescriptionRepository implements IPrescription
{
    private $indexService;

    public function __construct(
        PrescriptionIndexService $indexService,
    ) {
        $this->indexService = $indexService;
    }

    public function index()
    {
        return $this->indexService->boot();
    }
}
