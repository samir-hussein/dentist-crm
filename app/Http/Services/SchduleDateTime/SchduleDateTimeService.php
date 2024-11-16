<?php

namespace App\Http\Services\SchduleDateTime;

use App\Http\Services\BaseService;
use App\Models\SchduleDateTime;

class SchduleDateTimeService extends BaseService
{
    public function __construct(SchduleDateTime $model)
    {
        parent::__construct($model);
    }
}
