<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    // Fillable fields for mass assignment
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'date',
        'time',
        'notes',
        'completed',
        'visit_no'
    ];

    // Boot method to define model event
    protected static function boot()
    {
        parent::boot();

        // Before creating an appointment, set the visit_no
        static::creating(function ($appointment) {
            // Check if there's an existing appointment on the same date
            $lastVisitNo = Appointment::where('date', $appointment->date)
                ->max('visit_no');

            // If there's no previous visit number for that date, start from 1, else increment by 1
            $appointment->visit_no = $lastVisitNo ? $lastVisitNo + 1 : 1;
        });

        static::updating(function ($appointment) {
            // Check if there's an existing appointment on the same date
            $lastVisitNo = Appointment::where('date', $appointment->date)
                ->max('visit_no');

            // If there's no previous visit number for that date, start from 1, else increment by 1
            $appointment->visit_no = $lastVisitNo ? $lastVisitNo + 1 : 1;
        });
    }

    // Relationships

    /**
     * Get the patient that owns the appointment.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function services()
    {
        return $this->hasManyThrough(Service::class, AppointmentService::class, 'appointment_id', 'id', 'id', 'service_id');
    }

    public function appointment_services()
    {
        return $this->hasMany(AppointmentService::class);
    }

    /**
     * Get the doctor that owns the appointment.
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
