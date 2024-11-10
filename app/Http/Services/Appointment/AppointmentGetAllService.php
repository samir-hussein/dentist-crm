<?php

namespace App\Http\Services\Appointment;

use App\Models\Appointment;
use App\Http\Services\SchduleDate\SchduleDateStoreService;

class AppointmentGetAllService extends AppointmentService
{
    private $schduleDateStoreService;

    public function __construct(
        SchduleDateStoreService $schduleDateStoreService,
        Appointment $model,
    ) {
        parent::__construct($model);
        $this->schduleDateStoreService = $schduleDateStoreService;
    }

    public function boot($today = false)
    {
        $this->schduleDateStoreService->boot();

        // Fetch all columns from your model's table
        $data = $this->model->with([
            "patient" => function ($q) {
                $q->select(['patients.id', 'name', 'phone', 'phone2']);
            },
            "doctor" => function ($q) {
                $q->select(['users.id', 'name']);
            },
            "services" => function ($q) {
                $q->select(['services.id', 'name']);
            },
            "time" => function ($q) {
                $q->select(['schdule_date_times.id', 'time', 'manually_updated_time']);
            }
        ])->join('schdule_date_times', 'schdule_date_times.id', '=', 'appointments.time_id')
            ->orderBy('schdule_date_times.time')
            ->select("appointments.*")
            ->where("completed", false)
            ->where("schdule_date_times.is_deleted", false);

        if ($today) {
            $data->whereDate('schdule_date_times.time', today());
        }

        if (auth()->user()->is_doctor) {
            $data->where("doctor_id", auth()->user()->id);
        }

        $data = $data->get()->map(function ($appointment) {
            $appointment->selectedServices = $appointment->services->map(function ($service) {
                return $service->name;
            })->implode(' - ');

            $appointment->formatedTime = $appointment->time?->manually_updated_time?->format("l d-m-Y h:i a") ?? $appointment->time?->time->format("l d-m-Y h:i a") ?? "";

            return $appointment;
        });

        return $data;
    }
}
