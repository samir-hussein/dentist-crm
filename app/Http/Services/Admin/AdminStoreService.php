<?php

namespace App\Http\Services\Admin;

class AdminStoreService extends AdminService
{
    public function boot(array $data)
    {
        $data['is_admin'] = true;

        $this->model->create($data);

        return $this->success();
    }
}
