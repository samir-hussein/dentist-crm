<?php

namespace App\Http\Services\Admin;

class AdminStoreService extends AdminService
{
    public function boot(array $data)
    {
        $data['is_admin'] = true;
        $data['unique_id'] = $data['password'];

        $this->model->create($data);

        return $this->success();
    }
}
