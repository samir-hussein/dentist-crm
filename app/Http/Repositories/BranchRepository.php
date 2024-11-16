<?php

namespace App\Http\Repositories;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Interfaces\IBranch;
use App\Http\Services\Branch\BranchStoreService;
use App\Http\Services\Branch\BranchDeleteService;
use App\Http\Services\Branch\BranchGetAllService;
use App\Http\Services\Branch\BranchUpdateService;
use App\Http\Services\Branch\BranchFindByIdService;
use App\Http\Services\Branch\BranchListService;

class BranchRepository implements IBranch
{
    private $branchGetAllService;
    private $branchStoreService;
    private $branchDeleteService;
    private $branchFindById;
    private $branchUpdateService;
    private $listService;

    public function __construct(
        BranchGetAllService $branchGetAllService,
        BranchStoreService $branchStoreService,
        BranchDeleteService $branchDeleteService,
        BranchFindByIdService $branchFindById,
        BranchUpdateService $branchUpdateService,
        BranchListService $listService
    ) {
        $this->branchGetAllService = $branchGetAllService;
        $this->branchStoreService = $branchStoreService;
        $this->branchDeleteService = $branchDeleteService;
        $this->branchFindById = $branchFindById;
        $this->branchUpdateService = $branchUpdateService;
        $this->listService = $listService;
    }

    public function all(Request $request)
    {
        return $this->branchGetAllService->boot($request);
    }

    public function listService()
    {
        return $this->listService->boot();
    }

    public function findById(Branch $branch)
    {
        return $this->branchFindById->boot($branch);
    }

    public function store(array $data)
    {
        return $this->branchStoreService->boot($data);
    }

    public function update(Branch $branch, array $data)
    {
        return $this->branchUpdateService->boot($branch, $data);
    }

    public function delete(Branch $branch)
    {
        return $this->branchDeleteService->boot($branch);
    }
}
