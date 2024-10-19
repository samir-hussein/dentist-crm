<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchduleDay extends Model
{
    use HasFactory;

    protected $fillable = ['day'];

    public function pattern()
    {
        return $this->hasMany(SchduleDayPattern::class);
    }
}
