<?php

namespace App\Http\Repositories;

use App\Models\SchduleDay;
use Illuminate\Http\Request;
use App\Http\Interfaces\ISchduleDay;
use App\Http\Services\SchduleDay\SchduleDayStoreService;
use App\Http\Services\SchduleDay\SchduleDayDeleteService;
use App\Http\Services\SchduleDay\SchduleDayFindByIdService;
use App\Http\Services\SchduleDay\SchduleDayGetAllService;
use App\Http\Services\SchduleDay\SchduleDayUpdateService;

class SchduleDayRepository implements ISchduleDay
{
    private $schduleDayGetAllService;
    private $schduleDayStoreService;
    private $schduleDayDeleteService;
    private $schduleDayFindByIdService;
    private $schduleDayUpdateService;

    public function __construct(
        SchduleDayGetAllService $schduleDayGetAllService,
        SchduleDayStoreService $schduleDayStoreService,
        SchduleDayDeleteService $schduleDayDeleteService,
        SchduleDayFindByIdService $schduleDayFindByIdService,
        SchduleDayUpdateService $schduleDayUpdateService
    ) {
        $this->schduleDayGetAllService = $schduleDayGetAllService;
        $this->schduleDayStoreService = $schduleDayStoreService;
        $this->schduleDayDeleteService = $schduleDayDeleteService;
        $this->schduleDayFindByIdService = $schduleDayFindByIdService;
        $this->schduleDayUpdateService = $schduleDayUpdateService;
    }

    public function all(Request $request)
    {
        return $this->schduleDayGetAllService->boot($request);
    }

    public function findById(SchduleDay $schduleDay)
    {
        return $this->schduleDayFindByIdService->boot($schduleDay);
    }

    public function store(array $data)
    {
        return $this->schduleDayStoreService->boot($data);
    }

    public function update(SchduleDay $schduleDay, array $data)
    {
        return $this->schduleDayUpdateService->boot($schduleDay, $data);
    }

    public function delete(SchduleDay $schduleDay)
    {
        return $this->schduleDayDeleteService->boot($schduleDay);
    }
}
