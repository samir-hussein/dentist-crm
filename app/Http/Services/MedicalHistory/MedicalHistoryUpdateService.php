<?php

namespace App\Http\Services\MedicalHistory;

use Illuminate\Database\Eloquent\Model;

class MedicalHistoryUpdateService extends MedicalHistoryService
{
    public function boot(Model $model, array $data)
    {
        $model->update($data);

        return $this->success();
    }
}
