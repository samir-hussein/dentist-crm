<?php

namespace App\Http\Interfaces;

use App\Models\SchduleDate;
use Illuminate\Http\Request;

interface ISchduleDate
{
    public function all(Request $request);
    public function store();
    public function update(int $appointmentId, array $requestData);
    public function makeHoliday(SchduleDate $schduleDate);
    public function findById(SchduleDate $schduleDate);
    public function destroyAppointment(int $appointmentId);
}
