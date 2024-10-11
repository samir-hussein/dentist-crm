<?php

namespace App\Http\Services\Service;

class ServiceListService extends ServiceService
{
    public function boot()
    {
        $data = $this->model->get(['id', 'name']);

        return $data;
    }
}
