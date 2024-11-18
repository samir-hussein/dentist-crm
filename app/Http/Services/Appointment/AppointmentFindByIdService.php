<?php

namespace App\Http\Services\Appointment;

use App\Models\Appointment;

class AppointmentFindByIdService extends AppointmentService
{
    private $appointmentNecessaryData;

    public function __construct(
        AppointmentNecessaryDataService $appointmentNecessaryData,
    ) {
        $this->appointmentNecessaryData = $appointmentNecessaryData;
    }

    public function boot(Appointment $appointment)
    {
        $data = $this->appointmentNecessaryData->boot();
        $data->appointment = $appointment->load(
            [
                "patient" => function ($q) {
                    $q->select(["id", "name", "phone"]);
                },
                "patient.labOrder" => function ($q) {
                    $q->select(['lab_orders.id', 'patient_id', 'lab_id', 'sent', 'received']);
                },
                "patient.labOrder.lab" => function ($q) {
                    $q->select(['labs.id', 'name']);
                },
                "services" => function ($q) {
                    $q->select(["services.id", "services.name"]);
                },
                "doctor" => function ($q) {
                    $q->select(["id", "name"]);
                },
                "branch" => function ($q) {
                    $q->select(["id", "name"]);
                },
                "time",
                "time.schduleDate"
            ]
        );

        $data->appointment->selected_services = $data->appointment->services->pluck('id')->toArray();
        unset($data->appointment->services);
        return $data;
    }
}
