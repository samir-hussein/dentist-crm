<?php

namespace App\Http\Services\Appointment;

use Carbon\Carbon;
use App\Models\Appointment;
use App\Http\Services\Doctor\DoctorListService;
use App\Http\Services\SchduleDate\SchduleDateStoreService;

class AppointmentGetAllService extends AppointmentService
{
    private $schduleDateStoreService;
    private $doctorListService;

    public function __construct(
        SchduleDateStoreService $schduleDateStoreService,
        Appointment $model,
        DoctorListService $doctorListService,
    ) {
        parent::__construct($model);
        $this->schduleDateStoreService = $schduleDateStoreService;
        $this->doctorListService = $doctorListService;
    }

    public function boot($today = false)
    {
        $this->schduleDateStoreService->boot();

        // Fetch all columns from your model's table
        $data = $this->model->with([
            "patient" => function ($q) {
                $q->select(['patients.id', 'name', 'phone', 'phone2', 'code']);
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

        $request = request();

        if ($request->from && $request->from != "") {
            // Convert milliseconds to seconds and format as date
            $timestamp = $request->from / 1000;
            $from = Carbon::createFromTimestamp($timestamp)->startOfDay(); // Set to 00:00:00 of the given date
            $data->whereDate('schdule_date_times.time', '>=', $from);
        }

        if ($request->to && $request->to != "") {
            // Convert milliseconds to seconds and format as date
            $timestamp = $request->to / 1000;
            $to = Carbon::createFromTimestamp($timestamp)->endOfDay(); // Set to 23:59:59 of the given date
            $data->whereDate('schdule_date_times.time', '<=', $to);
        }

        if ((!$request->to && !$request->from) || ($request->from == "" && $request->to == "")) {
            $data->whereDate('schdule_date_times.time', today());
        }

        if ($request->doctor && $request->doctor != "") {
            $data->where("doctor_id", $request->doctor);
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

        return [
            "data" => $data,
            "doctors" => $this->doctorListService->boot(),
        ];
    }
}
