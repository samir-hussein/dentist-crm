<?php

namespace App\Http\Services\Service;

use App\Models\Service;

class ServiceUpdateService extends ServiceService
{
    public function boot(Service $service, array $data)
    {
        $service->update($data);

        return $this->success();
    }
}
