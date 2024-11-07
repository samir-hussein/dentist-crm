<?php

namespace App\Http\Services\LabOrder;

use Illuminate\Database\Eloquent\Model;

class LabOrderUpdateService extends LabOrderService
{
    public function boot(Model $model, array $data)
    {
        $model->update($data);

        return $this->success();
    }
}
