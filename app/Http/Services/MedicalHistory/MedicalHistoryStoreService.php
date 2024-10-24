<?php

namespace App\Http\Services\MedicalHistory;

class MedicalHistoryStoreService extends MedicalHistoryService
{
    public function boot(array $data)
    {
        $this->model->create($data);

        return $this->success();
    }
}
