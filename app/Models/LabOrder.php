<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabOrder extends Model
{
    use HasFactory;

    // Define the fillable properties
    protected $fillable = [
        'work',
        'cost',
        'done',
        'custom_data',
        'tooth',
        'sent',
        'received',
        'patient_id',
        'lab_id',
        'treatment_detail_id',
    ];

    // Specify casts for fields
    protected $casts = [
        'done' => 'boolean',
        'tooth' => 'array',
        'custom_data' => 'array',
        'sent' => 'date',
        'received' => 'date',
    ];

    /**
     * Relationship with the Patient model.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Relationship with the Lab model.
     */
    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }

    /**
     * Relationship with the TreatmentDetail model.
     */
    public function treatmentDetail()
    {
        return $this->belongsTo(TreatmentDetail::class);
    }
}
