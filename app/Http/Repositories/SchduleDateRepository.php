<?php

namespace App\Http\Repositories;

use App\Models\SchduleDate;
use Illuminate\Http\Request;
use App\Http\Interfaces\ISchduleDate;
use App\Http\Services\SchduleDay\SchduleDayDeleteService;
use App\Http\Services\SchduleDay\SchduleDayUpdateService;
use App\Http\Services\SchduleDate\SchduleDateStoreService;
use App\Http\Services\SchduleDate\SchduleDateGetAllService;
use App\Http\Services\SchduleDay\SchduleDayFindByIdService;

class SchduleDateRepository implements ISchduleDate
{
    private $schduleDateGetAllService;
    private $schduleDateStoreService;
    private $schduleDayDeleteService;
    private $schduleDayFindByIdService;
    private $schduleDayUpdateService;

    public function __construct(
        SchduleDateGetAllService $schduleDateGetAllService,
        SchduleDateStoreService $schduleDateStoreService,
        SchduleDayDeleteService $schduleDayDeleteService,
        SchduleDayFindByIdService $schduleDayFindByIdService,
        SchduleDayUpdateService $schduleDayUpdateService
    ) {
        $this->schduleDateGetAllService = $schduleDateGetAllService;
        $this->schduleDateStoreService = $schduleDateStoreService;
        $this->schduleDayDeleteService = $schduleDayDeleteService;
        $this->schduleDayFindByIdService = $schduleDayFindByIdService;
        $this->schduleDayUpdateService = $schduleDayUpdateService;
    }

    public function all(Request $request)
    {
        return $this->schduleDateGetAllService->boot($request);
    }

    public function findById(SchduleDate $schduleDay)
    {
        return $this->schduleDayFindByIdService->boot($schduleDay);
    }

    public function store()
    {
        return $this->schduleDateStoreService->boot();
    }

    public function update(SchduleDate $schduleDay, array $data)
    {
        return $this->schduleDayUpdateService->boot($schduleDay, $data);
    }

    public function delete(SchduleDate $schduleDay)
    {
        return $this->schduleDayDeleteService->boot($schduleDay);
    }
}
