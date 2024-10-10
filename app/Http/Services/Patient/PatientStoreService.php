<?php

namespace App\Http\Services\Patient;

class PatientStoreService extends PatientService
{
    public function boot(array $data)
    {
        return $this->model->create($data);
    }
}
