<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    // Define the fillable properties
    protected $fillable = [
        'fees',
        'paid',
        'tooth',
        'treatment',
        'patient_id',
        'tax_invoice',
        'treatment_detail_id',
        'doctor_id'
    ];

    // Specify casts for fields
    protected $casts = [
        'tax_invoice' => 'boolean',
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
     * Relationship with the TreatmentDetail model.
     */
    public function treatmentDetail()
    {
        return $this->belongsTo(TreatmentDetail::class);
    }
}
