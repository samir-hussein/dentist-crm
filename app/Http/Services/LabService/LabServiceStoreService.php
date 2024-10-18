<?php

namespace App\Http\Services\LabService;

class LabServiceStoreService extends LabServiceService
{
    public function boot(array $data)
    {
        $this->model->create($data);

        return $this->success();
    }
}
