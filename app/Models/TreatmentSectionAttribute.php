<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentSectionAttribute extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'has_inputs',
        'treatment_section_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'has_inputs' => 'boolean',
    ];

    public function inputs()
    {
        return $this->hasMany(TreatmentSectionAttributeInput::class, 'treatment_section_attribute_id');
    }

    /**
     * Get the treatment section that this attribute belongs to.
     */
    public function treatmentSection()
    {
        return $this->belongsTo(TreatmentSection::class, 'treatment_section_id');
    }
}
