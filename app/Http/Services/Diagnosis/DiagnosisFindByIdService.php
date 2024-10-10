<?php

namespace App\Http\Services\Diagnosis;

class DiagnosisFindByIdService extends DiagnosisService
{
    public function boot(int $diagnosis)
    {
        return $this->model->find($diagnosis);
    }
}
