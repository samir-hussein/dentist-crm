<?php

namespace App\Http\Services\Service;

use App\Models\Service;

class ServiceDeleteService extends ServiceService
{
    public function boot(Service $service)
    {
        $service->delete();

        return $this->success();
    }
}
