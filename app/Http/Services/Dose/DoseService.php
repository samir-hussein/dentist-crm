<?php

namespace App\Http\Services\Dose;

use App\Http\Services\BaseService;
use App\Models\Dose;

class DoseService extends BaseService
{
    public function __construct(Dose $model)
    {
        parent::__construct($model);
    }
}
