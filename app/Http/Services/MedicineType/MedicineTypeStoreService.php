<?php

namespace App\Http\Services\MedicineType;

class MedicineTypeStoreService extends MedicineTypeService
{
    public function boot(array $data)
    {
        $this->model->create($data);

        return $this->success();
    }
}
