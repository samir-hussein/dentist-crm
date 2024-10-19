<?php

namespace App\Http\Services\SchduleDay;

use App\Http\Services\BaseService;
use App\Models\SchduleDay;

class SchduleDayService extends BaseService
{
    public function __construct(SchduleDay $model)
    {
        parent::__construct($model);
    }
}
