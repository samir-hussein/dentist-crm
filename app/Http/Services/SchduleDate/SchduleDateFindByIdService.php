<?php

namespace App\Http\Services\SchduleDate;

use Illuminate\Database\Eloquent\Model;

class SchduleDateFindByIdService extends SchduleDateService
{
    public function boot(Model $model)
    {
        return $model->load(['schduleDay', 'appointments' => function ($q) {
            $q->where('is_deleted', false)->orderBy("time");
        }]);
    }
}
