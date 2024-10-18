<?php

namespace App\Http\Services\LabService;

use App\Http\Services\BaseService;
use App\Models\LabService;

class LabServiceService extends BaseService
{
    public function __construct(LabService $model)
    {
        parent::__construct($model);
    }
}
