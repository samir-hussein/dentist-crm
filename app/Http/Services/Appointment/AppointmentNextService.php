<?php

namespace App\Http\Services\Appointment;

use Carbon\Carbon;
use App\Models\User;
use App\Facades\Firebase;
use App\Models\Appointment;
use App\Models\SchduleDate;
use App\Models\SchduleDateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppointmentNextService extends AppointmentService
{
    public function boot(Appointment $appointment, array $data)
    {
        DB::beginTransaction();

        try {
            if ($appointment->completed) {
                return $this->error('Cannot set next appointment for completed appointment.', 403);
            }

            if ($data['urgent_time'] && !$data['time_id']) {
                $date = SchduleDate::find($data['date_id']);
                $time = Carbon::parse($date->date)->setTimeFromTimeString($data['urgent_time']);
                $checkTime = SchduleDateTime::where("time", $time)->where("doctor_id", $data['doctor_id'])->first();

                if ($checkTime) {
                    return $this->error("The Doctor already have appointment in this time.", 400);
                }

                $time = SchduleDateTime::create([
                    "time" => $time,
                    "schdule_date_id" => $date->id,
                    "urgent" => true,
                    "doctor_id" => $data['doctor_id'],
                    "branch_id" => $data['branch_id'],
                ]);

                $data['time_id'] = $time->id;
            }

            $check_appointment = $this->model->where("patient_id", $data['patient_id'])->where("doctor_id", $data['doctor_id'])->where("time_id", $data['time_id'])->first();

            if ($check_appointment) {
                return $this->error("This appointment already exists.", 400);
            }

            $check_doctor_busy = $this->model->where("doctor_id", $data['doctor_id'])->where("time_id", $data['time_id'])->first();

            if ($check_doctor_busy) {
                return $this->error("The Doctor already have appointment in this time.", 400);
            }

            $appointment->update([
                "completed" => 1
            ]);

            $appointment = $this->model->create($data);

            SchduleDateTime::where("id", $data['time_id'])->update([
                "patient_id" => $data['patient_id'],
            ]);

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
                'url' => route("patients.file", ['patient' => $appointment->patient_id])
            ];

            try {
                Firebase::sendNotification($user->tokens(), $payload);
            } catch (\Throwable $th) {
                Log::info($th->getMessage() . " : " . $th->getTraceAsString());
            }

            return $this->success();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::info($th->getMessage() . " : " . $th->getTraceAsString());
            return $this->error("Something went wrong!", 500);
        }
    }
}
