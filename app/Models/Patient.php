<?php

namespace App\Models;

use Carbon\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'date_of_birth',
        'gender',
        'phone2',
        'phone',
        'nationality',
        'need_invoice',
        'medical_history',
        'code'
    ];

    // Define a boot method to hook into the model's creating event
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($patient) {
            // Generate patient code before creating
            $patient->code = self::generatePatientCode();
        });
    }

    // Generate the patient code
    public static function generatePatientCode()
    {
        // Get the last patient code or set to 0 if no patients exist
        $lastPatient = self::latest()->first();

        // Extract the patient number from the last code and increment it by 1
        $patientNumber = $lastPatient ? (int) substr($lastPatient->code, 3) + 1 : 1;

        // Return the new code in the format 'pt_1', 'pt_2', etc.
        return 'pt_' . $patientNumber;
    }

    // Accessor to calculate age
    public function getAgeAttribute()
    {
        return Carbon::parse($this->attributes['date_of_birth'])->age;
    }

    public function treatmentSessions()
    {
        return $this->hasMany(TreatmentDetail::class);
    }

    public function labOrder()
    {
        return $this->hasOne(LabOrder::class)->where("done", 0)->latest();
    }
}
