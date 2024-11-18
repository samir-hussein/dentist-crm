<?php

namespace App\Http\Services\Appointment;

use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\SchduleDate;
use App\Models\SchduleDateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppointmentUpdateService extends AppointmentService
{
    public function boot(Appointment $appointment, array $data)
    {
        DB::beginTransaction();

        try {
            //code...
            if ($appointment->completed) {
                return $this->error('Cannot update completed appointment.', 403);
            }

            if ($data['urgent_time'] && !$data['time_id']) {
                $date = SchduleDate::find($data['date_id']);
                $time = Carbon::parse($date->date)->setTimeFromTimeString($data['urgent_time']);
                $checkTime = SchduleDateTime::where("time", $time)->where("patient_id", "!=", $appointment->patient_id)->where("doctor_id", $data['doctor_id'])->first();

                if ($checkTime) {
                    return $this->error("The Doctor already have appointment in this time.", 400);
                }

                $check_urgent = SchduleDateTime::where("id", $data['old_time_id'])->where("urgent", true)->first();

                if ($check_urgent) {
                    $check_urgent->update([
                        "time" => $time,
                        "schdule_date_id" => $date->id,
                        "doctor_id" => $data['doctor_id'],
                        "branch_id" => $data['branch_id'],
                    ]);

                    $data['time_id'] = $data['old_time_id'];
                } else {
                    $time = SchduleDateTime::create([
                        "time" => $time,
                        "schdule_date_id" => $date->id,
                        "urgent" => true,
                        "doctor_id" => $data['doctor_id'],
                        "branch_id" => $data['branch_id'],
                    ]);

                    $data['time_id'] = $time->id;
                }
            }

            $check_appointment = $this->model->where("id", "!=", $appointment->id)->where("patient_id", $appointment->patient_id)->where("doctor_id", $data['doctor_id'])->where("time_id", $data['time_id'])->first();

            if ($check_appointment) {
                return $this->error("This appointment already exists.", 400);
            }

            $check_doctor_busy = $this->model->where("id", "!=", $appointment->id)->where("doctor_id", $data['doctor_id'])->where("time_id", $data['time_id'])->first();

            if ($check_doctor_busy) {
                return $this->error("The Doctor already have appointment in this time.", 400);
            }

            $appointment->update($data);

            $services = array_map(function ($service_id) use ($appointment) {
                return [
                    'service_id' => $service_id,
                    'appointment_id' => $appointment->id
                ];
            }, $data['service_ids']);

            if ($data['time_id'] != $data['old_time_id']) {
                SchduleDateTime::where("id", $data['time_id'])->update([
                    "patient_id" => $appointment->patient_id,
                ]);

                if (!SchduleDateTime::where("id", $data['old_time_id'])->where("urgent", true)->delete()) {
                    SchduleDateTime::where("id", $data['old_time_id'])->update([
                        "patient_id" => null
                    ]);
                }
            }

            $appointment->appointment_services()->delete();

            $appointment->appointment_services()->insert($services);

            DB::commit();

            return $this->success();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            Log::info($th->getMessage() . " : " . $th->getTraceAsString());
            return $this->error("Something went wrong!", 500);
        }
    }
}
