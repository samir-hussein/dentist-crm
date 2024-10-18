<?php

namespace App\Http\Services\Dose;

class DoseStoreService extends DoseService
{
    public function boot(array $data)
    {
        $this->model->create($data);

        return $this->success();
    }
}
