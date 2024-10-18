<?php

namespace App\Http\Services\MedicineType;

use App\Http\Services\BaseService;
use App\Models\MedicineType;

class MedicineTypeService extends BaseService
{
    public function __construct(MedicineType $model)
    {
        parent::__construct($model);
    }
}
