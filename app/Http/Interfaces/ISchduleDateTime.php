<?php

namespace App\Http\Interfaces;

use Illuminate\Http\Request;

interface ISchduleDateTime
{
    public function doctorList(int $branchId, int $dayId);
    public function datesList(int $branchId, int $doctorId);
    public function timeList(int $branchId, int $doctorId, int $dateId);
}
