<?php

namespace App\Http\Services\LabOrder;

use App\Http\Services\BaseService;
use App\Models\LabOrder;

class LabOrderService extends BaseService
{
    public function __construct(LabOrder $model)
    {
        parent::__construct($model);
    }
}
