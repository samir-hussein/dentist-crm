<?php

namespace App\Http\Services\Diagnosis;

class DiagnosisUpdateService extends DiagnosisService
{
    public function boot(int $diagnosis, array $data)
    {
        $this->model->where("id", $diagnosis)->update($data);

        return $this->success();
    }
}
