<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentSectionAttributeInput extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'value',
        'treatment_section_attribute_id',
    ];

    /**
     * Get the treatment section attribute that this input belongs to.
     */
    public function treatmentSectionAttribute()
    {
        return $this->belongsTo(TreatmentSectionAttribute::class, 'treatment_section_attribute_id');
    }
}
