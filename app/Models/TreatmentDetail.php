<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TreatmentDetail extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    // Define the fillable properties
    protected $fillable = [
        'tooth',
        'data',
        'patient_id',
        'diagnose_id',
        'doctor_id',
        'tooth_type',
        'treatment'
    ];

    // Specify the data column as JSON cast
    protected $casts = [
        'data' => 'array',
        'tooth' => 'array',
    ];

    /**
     * Relationship with the Patient model.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Relationship with the Diagnose model.
     */
    public function diagnose()
    {
        return $this->belongsTo(Diagnosis::class);
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }

    public function labOrder()
    {
        return $this->hasOne(LabOrder::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class);
    }
}
