<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'morning_shift',
        'night_shift',
        'assistant_id',
    ];

    /**
     * Define the relationship to the Assistant model.
     */
    public function assistant()
    {
        return $this->belongsTo(Assistant::class);
    }
}
