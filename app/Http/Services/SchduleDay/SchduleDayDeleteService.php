<?php

namespace App\Http\Services\SchduleDay;

use Illuminate\Database\Eloquent\Model;

class SchduleDayDeleteService extends SchduleDayService
{
    public function boot(Model $model)
    {
        $model->delete();

        return $this->success();
    }
}
