<?php

namespace App\Http\Services\Doctor;

use Illuminate\Database\Eloquent\Model;

class DoctorUpdateService extends DoctorService
{
    public function boot(Model $model, array $data)
    {
        $model->update($data);
        return $this->success();
    }
}
