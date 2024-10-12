<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiagnosisTreatment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'diagnosis_id',
        'treatment_type_id',
    ];

    /**
     * Get the diagnosis that this treatment is related to.
     */
    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class, 'diagnosis_id');
    }

    /**
     * Get the treatment type that is linked to this diagnosis.
     */
    public function treatmentType()
    {
        return $this->belongsTo(TreatmentType::class, 'treatment_type_id');
    }
}
