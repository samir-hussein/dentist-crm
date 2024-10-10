<?php

namespace App\Http\Services\Diagnosis;

class DiagnosisDeleteService extends DiagnosisService
{
    public function boot(int $diagnosis)
    {
        $this->model->where("id", $diagnosis)->delete();

        return $this->success();
    }
}
