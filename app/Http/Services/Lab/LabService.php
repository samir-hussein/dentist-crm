<?php

namespace App\Http\Services\Lab;

use App\Http\Services\BaseService;
use App\Models\Lab;

class LabService extends BaseService
{
    public function __construct(Lab $model)
    {
        parent::__construct($model);
    }
}
