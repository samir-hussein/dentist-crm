<?php

namespace App\Http\Services\Medicine;

class MedicineListService extends MedicineService
{
    public function boot()
    {
        $data = $this->model->get(['id', 'name']);

        return $data;
    }
}
