<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'medicine_type_id'];

    public function medicineType()
    {
        return $this->belongsTo(MedicineType::class);
    }
}
