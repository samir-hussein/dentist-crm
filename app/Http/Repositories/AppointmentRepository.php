<?php

namespace App\Http\Repositories;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Interfaces\IAppointment;
use App\Http\Services\Appointment\AppointmentStoreService;
use App\Http\Services\Appointment\AppointmentDeleteService;
use App\Http\Services\Appointment\AppointmentGetAllService;
use App\Http\Services\Appointment\AppointmentUpdateService;
use App\Http\Services\Appointment\AppointmentFindByIdService;
use App\Http\Services\Appointment\AppointmentCompletedService;

class AppointmentRepository implements IAppointment
{
    private $appointmentGetAllService;
    private $appointmentStoreService;
    private $appointmentDeleteService;
    private $appointmentUpdateService;
    private $appointmentFindByIdService;
    private $appointmentCompletedService;

    public function __construct(
        AppointmentGetAllService $appointmentGetAllService,
        AppointmentStoreService $appointmentStoreService,
        AppointmentDeleteService $appointmentDeleteService,
        AppointmentUpdateService $appointmentUpdateService,
        AppointmentCompletedService $appointmentCompletedService,
        AppointmentFindByIdService $appointmentFindByIdService,
    ) {
        $this->appointmentGetAllService = $appointmentGetAllService;
        $this->appointmentStoreService = $appointmentStoreService;
        $this->appointmentDeleteService = $appointmentDeleteService;
        $this->appointmentUpdateService = $appointmentUpdateService;
        $this->appointmentFindByIdService = $appointmentFindByIdService;
        $this->appointmentCompletedService = $appointmentCompletedService;
    }

    public function all(Request $request)
    {
        return $this->appointmentGetAllService->boot($request);
    }

    public function findById(Appointment $appointment)
    {
        return $this->appointmentFindByIdService->boot($appointment);
    }

    public function store(array $data)
    {
        return $this->appointmentStoreService->boot($data);
    }

    public function update(Appointment $appointment, array $data)
    {
        return $this->appointmentUpdateService->boot($appointment, $data);
    }

    public function delete(Appointment $appointment)
    {
        return $this->appointmentDeleteService->boot($appointment);
    }

    public function markCompleted(Appointment $appointment)
    {
        return $this->appointmentCompletedService->boot($appointment);
    }
}
