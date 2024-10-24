<?php

namespace App\Http\Services\Appointment;

class AppointmentGetAllService extends AppointmentService
{
    public function boot()
    {
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
                $q->select(['schdule_date_times.id', 'time']);
            }
        ])->join('schdule_date_times', 'schdule_date_times.id', '=', 'appointments.time_id')
            ->orderBy('schdule_date_times.time')
            ->select("appointments.*")
            ->where("completed", false)
            ->get()->map(function ($appointment) {
                $appointment->selectedServices = $appointment->services->map(function ($service) {
                    return $service->name;
                })->implode(' - ');

                $appointment->formatedTime = $appointment->time?->time->format("l Y-m-d h:i a") ?? "";

                return $appointment;
            });

        return $data;
    }
}
