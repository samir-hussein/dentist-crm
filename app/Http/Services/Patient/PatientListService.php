<?php

namespace App\Http\Services\Patient;

class PatientListService extends PatientService
{
    public function boot()
    {
        $data = $this->model->get(['id', 'name', 'phone', 'phone2', 'code']);

        return $data;
    }
}
