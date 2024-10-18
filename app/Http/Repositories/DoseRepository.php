<?php

namespace App\Http\Repositories;

use App\Models\Dose;
use Illuminate\Http\Request;
use App\Http\Interfaces\IDose;
use App\Http\Services\Dose\DoseStoreService;
use App\Http\Services\Dose\DoseDeleteService;
use App\Http\Services\Dose\DoseGetAllService;
use App\Http\Services\Dose\DoseUpdateService;
use App\Http\Services\Dose\DoseFindByIdService;

class DoseRepository implements IDose
{
    private $doseGetAllService;
    private $doseStoreService;
    private $doseDeleteService;
    private $doseFindByIdService;
    private $doseUpdateService;

    public function __construct(
        DoseGetAllService $doseGetAllService,
        DoseStoreService $doseStoreService,
        DoseDeleteService $doseDeleteService,
        DoseFindByIdService $doseFindByIdService,
        DoseUpdateService $doseUpdateService,
    ) {
        $this->doseGetAllService = $doseGetAllService;
        $this->doseStoreService = $doseStoreService;
        $this->doseDeleteService = $doseDeleteService;
        $this->doseFindByIdService = $doseFindByIdService;
        $this->doseUpdateService = $doseUpdateService;
    }

    public function all(Request $request)
    {
        return $this->doseGetAllService->boot($request);
    }

    public function findById(Dose $dose)
    {
        return $this->doseFindByIdService->boot($dose);
    }

    public function store(array $data)
    {
        return $this->doseStoreService->boot($data);
    }

    public function update(Dose $dose, array $data)
    {
        return $this->doseUpdateService->boot($dose, $data);
    }

    public function delete(Dose $dose)
    {
        return $this->doseDeleteService->boot($dose);
    }
}
