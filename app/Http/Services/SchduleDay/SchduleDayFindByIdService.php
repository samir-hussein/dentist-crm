<?php

namespace App\Http\Services\SchduleDay;

use Illuminate\Database\Eloquent\Model;

class SchduleDayFindByIdService extends SchduleDayService
{
    public function boot(Model $model)
    {
        return $model->load('pattern');
    }
}
