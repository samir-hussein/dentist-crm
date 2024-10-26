<?php

namespace App\Http\Services\Prescription;

use App\Http\Services\BaseService;
use App\Models\MedicineType;

class PrescriptionService extends BaseService
{
    public function __construct(MedicineType $model)
    {
        parent::__construct($model);
    }
}
