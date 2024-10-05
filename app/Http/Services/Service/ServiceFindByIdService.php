<?php

namespace App\Http\Services\Service;

use App\Models\Service;

class ServiceFindByIdService extends ServiceService
{
    public function boot(Service $service)
    {
        return $service;
    }
}
