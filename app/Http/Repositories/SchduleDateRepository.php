<?php

namespace App\Http\Repositories;

use App\Models\SchduleDate;
use Illuminate\Http\Request;
use App\Http\Interfaces\ISchduleDate;
use App\Http\Services\SchduleDay\SchduleDayUpdateService;
use App\Http\Services\SchduleDate\SchduleDateStoreService;
use App\Http\Services\SchduleDate\SchduleDateGetAllService;
use App\Http\Services\SchduleDate\SchduleDateFindByIdService;
use App\Http\Services\SchduleDate\SchduleDateMakeHolidayService;
use App\Http\Services\SchduleDate\SchduleDateAppointmentDeleteService;
use App\Http\Services\SchduleDate\SchduleDateAppointmentUpdateService;

class SchduleDateRepository implements ISchduleDate
{
    private $schduleDateGetAllService;
    private $schduleDateStoreService;
    private $schduleDateMakeHolidayService;
    private $schduleDateFindByIdService;
    private $schduleDateAppointmentUpdateService;
    private $schduleDateAppointmentDeleteService;

    public function __construct(
        SchduleDateGetAllService $schduleDateGetAllService,
        SchduleDateStoreService $schduleDateStoreService,
        SchduleDateMakeHolidayService $schduleDateMakeHolidayService,
        SchduleDateFindByIdService $schduleDateFindByIdService,
        SchduleDateAppointmentUpdateService $schduleDateAppointmentUpdateService,
        SchduleDateAppointmentDeleteService $schduleDateAppointmentDeleteService,
    ) {
        $this->schduleDateGetAllService = $schduleDateGetAllService;
        $this->schduleDateStoreService = $schduleDateStoreService;
        $this->schduleDateMakeHolidayService = $schduleDateMakeHolidayService;
        $this->schduleDateFindByIdService = $schduleDateFindByIdService;
        $this->schduleDateAppointmentUpdateService = $schduleDateAppointmentUpdateService;
        $this->schduleDateAppointmentDeleteService = $schduleDateAppointmentDeleteService;
    }

    public function all(Request $request)
    {
        return $this->schduleDateGetAllService->boot($request);
    }

    public function findById(SchduleDate $schduleDate)
    {
        return $this->schduleDateFindByIdService->boot($schduleDate);
    }

    public function store()
    {
        return $this->schduleDateStoreService->boot();
    }

    public function update(int $appointmentId, array $data)
    {
        return $this->schduleDateAppointmentUpdateService->boot($appointmentId, $data);
    }

    public function makeHoliday(SchduleDate $schduleDate)
    {
        return $this->schduleDateMakeHolidayService->boot($schduleDate);
    }

    public function destroyAppointment(int $appointmentId)
    {
        return $this->schduleDateAppointmentDeleteService->boot($appointmentId);
    }
}
