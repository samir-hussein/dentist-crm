<?php

namespace App\Http\Services\Service;

class ServiceStoreService extends ServiceService
{
    public function boot(array $data)
    {
        $this->model->create($data);

        return $this->success();
    }
}
