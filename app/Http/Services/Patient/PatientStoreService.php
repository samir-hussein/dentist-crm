<?php

namespace App\Http\Services\Patient;

class PatientStoreService extends PatientService
{
    public function boot(array $data)
    {
        $this->model->create($data);

        return $this->success();
    }
}
