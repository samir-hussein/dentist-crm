<?php

namespace App\Http\Services\Medicine;

use App\Http\Services\BaseService;
use App\Models\Medicine;

class MedicineService extends BaseService
{
    public function __construct(Medicine $model)
    {
        parent::__construct($model);
    }
}
