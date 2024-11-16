<?php

namespace App\Http\Repositories;

use Illuminate\Http\Request;
use App\Http\Interfaces\ISchduleDateTime;
use App\Http\Services\SchduleDateTime\DateListService;
use App\Http\Services\SchduleDateTime\DoctorListService;
use App\Http\Services\SchduleDateTime\TimesListService;

class SchduleDateTimeRepository implements ISchduleDateTime
{

    public function __construct(private DoctorListService $doctorListService, private DateListService $dateListService, private TimesListService $timesListService) {}

    public function doctorList(int $branchId, int $dayId)
    {
        return $this->doctorListService->boot($branchId, $dayId);
    }

    public function datesList(int $branchId, int $doctorId)
    {
        return $this->dateListService->boot($branchId, $doctorId);
    }

    public function timeList(int $branchId, int $doctorId, int $dateId)
    {
        return $this->timesListService->boot($branchId, $doctorId, $dateId);
    }
}
