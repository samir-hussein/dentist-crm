<?php

namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Interfaces\IStaff;
use App\Http\Services\Staff\StaffStoreService;
use App\Http\Services\Staff\StaffDeleteService;
use App\Http\Services\Staff\StaffGetAllService;

class StaffRepository implements IStaff
{
    private $staffGetAllService;
    private $staffStoreService;
    private $staffDeleteService;

    public function __construct(
        StaffGetAllService $staffGetAllService,
        StaffStoreService $staffStoreService,
        StaffDeleteService $staffDeleteService
    ) {
        $this->staffGetAllService = $staffGetAllService;
        $this->staffStoreService = $staffStoreService;
        $this->staffDeleteService = $staffDeleteService;
    }

    public function all(Request $request)
    {
        return $this->staffGetAllService->boot($request);
    }

    public function store(array $data)
    {
        return $this->staffStoreService->boot($data);
    }

    public function delete(User $staff)
    {
        return $this->staffDeleteService->boot($staff);
    }
}
