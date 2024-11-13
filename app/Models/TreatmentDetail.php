<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentDetail extends Model
{
    use HasFactory;

    // Define the fillable properties
    protected $fillable = [
        'tooth',
        'data',
        'patient_id',
        'diagnose_id',
        'doctor_id',
        'tooth_type'
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
