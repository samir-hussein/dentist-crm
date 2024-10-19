<?php

namespace App\Http\Services\SchduleDate;

use App\Http\Services\BaseService;
use App\Models\SchduleDate;

class SchduleDateService extends BaseService
{
    public function __construct(SchduleDate $model)
    {
        parent::__construct($model);
    }
}
