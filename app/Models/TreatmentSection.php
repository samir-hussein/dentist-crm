<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentSection extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'multi_selection',
        'treatment_type_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'multi_selection' => 'boolean',
    ];

    public function attributes()
    {
        return $this->hasMany(TreatmentSectionAttribute::class);
    }

    /**
     * Get the treatment type that this section belongs to.
     */
    public function treatmentType()
    {
        return $this->belongsTo(TreatmentType::class, 'treatment_type_id');
    }
}
