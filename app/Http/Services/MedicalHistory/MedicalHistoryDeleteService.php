<?php

namespace App\Http\Services\MedicalHistory;

use Illuminate\Database\Eloquent\Model;

class MedicalHistoryDeleteService extends MedicalHistoryService
{
    public function boot(Model $model)
    {
        $model->delete();

        return $this->success();
    }
}
