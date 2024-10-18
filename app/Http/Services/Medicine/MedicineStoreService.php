<?php

namespace App\Http\Services\Medicine;

class MedicineStoreService extends MedicineService
{
    public function boot(array $data)
    {
        $this->model->create($data);

        return $this->success();
    }
}
