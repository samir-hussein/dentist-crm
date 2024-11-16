<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Interfaces\ISchduleDateTime;

class SchduleDateTimeController extends Controller
{
    public function __construct(private ISchduleDateTime $service) {}

    /**
     * Get a listing of the resource.
     */
    public function doctorList(int $branchId, int $dayId)
    {
        $data = $this->service->doctorList(branchId: $branchId, dayId: $dayId);

        return $data;
    }

    /**
     * Get a listing of the resource.
     */
    public function datesList(int $branchId, int $doctorId)
    {
        $data = $this->service->datesList(branchId: $branchId, doctorId: $doctorId);

        return $data;
    }

    /**
     * Get a listing of the resource.
     */
    public function timeList(int $branchId, int $doctorId, int $dateId)
    {
        $data = $this->service->timeList(branchId: $branchId, doctorId: $doctorId, dateId: $dateId);

        return $data;
    }
}
