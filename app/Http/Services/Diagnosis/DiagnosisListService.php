<?php

namespace App\Http\Services\Diagnosis;

class DiagnosisListService extends DiagnosisService
{
    public function boot()
    {
        $data = $this->model->get(['id', 'name']);

        return $data;
    }
}
