<?php

namespace App\Http\Services\SchduleDate;

use App\Models\SchduleDateTime;

class SchduleDateAvailableTimesService extends SchduleDateService
{
    public function boot()
    {
        return SchduleDateTime::where("is_deleted", false)->orderBy("time")->get();
    }
}
