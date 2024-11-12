<?php

namespace App\Http\Services\Branch;

class BranchStoreService extends BranchService
{
    public function boot(array $data)
    {
        $this->model->create($data);

        return $this->success();
    }
}
