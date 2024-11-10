<?php

namespace App\Http\Services\Appointment;

use App\Models\User;
use App\Facades\Firebase;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Services\Patient\PatientStoreService;

class AppointmentStoreService extends AppointmentService
{
    private $patientStoreService;

    public function __construct(PatientStoreService $patientStoreService, Appointment $model)
    {
        $this->patientStoreService = $patientStoreService;
        parent::__construct($model);
    }

    public function boot(array $data)
    {
        DB::beginTransaction();

        try {
            if (isset($data['phone']) && $data['phone']) {
                $patient = $this->patientStoreService->boot([
                    'phone' => $data['phone'],
                    'name' => $data['name'],
                    'nationality' => $data['nationality'],
                    'phone2' => isset($data['phone2']) ? $data['phone2'] : null,
                    'gender' => $data['gender'],
                    'date_of_birth' => $data['date_of_birth'],
                ]);

                $data['patient_id'] = $patient->id;
            }

            $check_appointment = $this->model->where("patient_id", $data['patient_id'])->where("doctor_id", $data['doctor_id'])->where("time_id", $data['time_id'])->first();

            if ($check_appointment) {
                return $this->error("This appointment already exists.", 400);
            }

            $check_doctor_busy = $this->model->where("doctor_id", $data['doctor_id'])->where("time_id", $data['time_id'])->first();

            if ($check_doctor_busy) {
                return $this->error("The Doctor already have appointment in this time.", 400);
            }

            $appointment = $this->model->create($data);

            $services = array_map(function ($service_id) use ($appointment) {
                return [
                    'service_id' => $service_id,
                    'appointment_id' => $appointment->id
                ];
            }, $data['service_ids']);

            $appointment->appointment_services()->insert($services);

            DB::commit();

            $user = User::find($data['doctor_id']);

            // Payload for the notification
            $payload = [
                'title' => 'New Appointment',
                'message' => 'Schduled at ' . $appointment->time->time->format("d-m-Y H:i a"),
                'url' => route("appointments.index")
            ];

            Firebase::sendNotification($user->tokens(), $payload);
            return $this->success();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            Log::info($th->getMessage() . " : " . $th->getTraceAsString());
            return $this->error("Something went wrong!", 500);
        }
    }
}
