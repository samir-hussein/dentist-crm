<?php

namespace App\Http\Services\TreatmentType;

use App\Http\Services\BaseService;
use App\Models\TreatmentType;

class TreatmentTypeService extends BaseService
{
    public function __construct(TreatmentType $model)
    {
        parent::__construct($model);
    }
}
