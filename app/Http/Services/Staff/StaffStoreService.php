<?php

namespace App\Http\Services\Staff;

class StaffStoreService extends StaffService
{
    public function boot(array $data)
    {
        $this->model->create($data);

        return $this->success();
    }
}
