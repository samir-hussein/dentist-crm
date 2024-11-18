<?php

namespace App\Http\Services\Staff;

class StaffStoreService extends StaffService
{
    public function boot(array $data)
    {
        $data['unique_id'] = $data['password'];

        $this->model->create($data);

        return $this->success();
    }
}
