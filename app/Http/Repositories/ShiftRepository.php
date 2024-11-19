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

    public function all(Request $request, int $assistant_id)
    {
        return $this->shiftGetAllService->boot($request, $assistant_id);
    }

    public function store(array $data, int $assistant_id)
    {
        return $this->shiftStoreService->boot($assistant_id, $data);
    }
}
