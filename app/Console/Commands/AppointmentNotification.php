<?php

namespace App\Console\Commands;

use App\Facades\Firebase;
use App\Models\Appointment;
use Illuminate\Console\Command;

class AppointmentNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:appointment-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Sending appointment notifications...');

        $appointments = Appointment::where("notified", 0)
            ->whereHas("time", function ($query) {
                $query->where("time", "<=", now()->addMinutes(5))
                    ->where("time", ">", now());
            })->with(['doctor', 'time'])
            ->get();

        foreach ($appointments as $appointment) {
            // Payload for the notification
            $payload = [
                'title' => 'Appointment within the next 5 minutes',
                'message' => 'Schduled at ' . $appointment->time->time->format("Y-m-d H:i a"),
                'url' => route("patients.profile", ['patient' => $appointment->patient_id])
            ];

            Firebase::sendNotification($appointment->doctor->tokens(), $payload);

            // Mark the appointment as notified
            $appointment->notified = 1;
            $appointment->save();
        }

        return $this->info('Finished notification');
    }
}