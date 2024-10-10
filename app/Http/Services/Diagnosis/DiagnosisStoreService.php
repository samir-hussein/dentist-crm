<?php

namespace App\Http\Services\Diagnosis;

class DiagnosisStoreService extends DiagnosisService
{
    public function boot(array $data)
    {
        $this->model->create($data);

        return $this->success();
    }
}
