<?php

namespace App\Http\Services\Lab;

class LabListService extends LabService
{
    public function boot()
    {
        $data = $this->model->get(['id', 'name']);

        return $data;
    }
}
