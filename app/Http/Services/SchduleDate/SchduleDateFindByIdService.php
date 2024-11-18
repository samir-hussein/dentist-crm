<?php

namespace App\Http\Services\SchduleDate;

use Illuminate\Database\Eloquent\Model;

class SchduleDateFindByIdService extends SchduleDateService
{
    public function boot(Model $model)
    {
        return $model->load(['schduleDay', 'appointments' => function ($q) {
            $q->where('is_deleted', false)->orderBy("time");

            if (auth()->user()->is_doctor) {
                $q->where("doctor_id", auth()->user()->id);
            }
        }, 'appointments.doctor', 'appointments.branch']);
    }
}
