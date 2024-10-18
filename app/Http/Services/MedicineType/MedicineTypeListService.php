<?php

namespace App\Http\Services\MedicineType;

class MedicineTypeListService extends MedicineTypeService
{
    public function boot()
    {
        $data = $this->model->get(['id', 'name']);

        return $data;
    }
}
