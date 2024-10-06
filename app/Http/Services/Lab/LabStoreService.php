<?php

namespace App\Http\Services\Lab;

class LabStoreService extends LabService
{
    public function boot(array $data)
    {
        $this->model->create($data);

        return $this->success();
    }
}
