<?php

namespace App\Http\Repositories;

use Illuminate\Http\Request;
use App\Http\Interfaces\IShift;
use App\Http\Services\Shift\ShiftStoreService;
use App\Http\Services\Shift\ShiftGetAllService;

class ShiftRepository implements IShift
{
    public function __construct(
        private ShiftGetAllService $shiftGetAllService,
        private ShiftStoreService $shiftStoreService,
    ) {}

    public function all(Request $request)
    {
        return $this->shiftGetAllService->boot($request);
    }

    public function store(array $data)
    {
        return $this->shiftStoreService->boot($data);
    }
}
