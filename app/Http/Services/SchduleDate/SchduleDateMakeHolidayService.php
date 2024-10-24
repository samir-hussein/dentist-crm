<?php

namespace App\Http\Services\SchduleDate;

use Illuminate\Database\Eloquent\Model;

class SchduleDateMakeHolidayService extends SchduleDateService
{
    public function boot(Model $model)
    {
        $model->update([
            "is_holiday" => !$model->is_holiday,
        ]);

        $model->appointments()->update([
            "is_deleted" => $model->is_holiday,
        ]);

        return $this->success();
    }
}
