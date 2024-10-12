<?php

namespace App\Http\Services\TreatmentType;

class TreatmentTypeListService extends TreatmentTypeService
{
    public function boot()
    {
        $data = $this->model->get();

        return $data;
    }
}
