<?php

namespace App\Http\Services\Service;

use App\Http\Services\BaseService;
use App\Models\Service;

class ServiceService extends BaseService
{
    public function __construct(Service $model)
    {
        parent::__construct($model);
    }
}
