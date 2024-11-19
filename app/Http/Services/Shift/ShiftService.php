<?php

namespace App\Http\Services\Shift;

use App\Http\Services\BaseService;
use App\Models\Shift;

class ShiftService extends BaseService
{
    public function __construct(Shift $model)
    {
        parent::__construct($model);
    }
}
