<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'need_labs',
        'description',
        'tooth_type'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'need_labs' => 'boolean',
    ];

    public function diagnosis()
    {
        return $this->hasMany(DiagnosisTreatment::class);
    }

    public function sections()
    {
        return $this->hasMany(TreatmentSection::class);
    }
}
