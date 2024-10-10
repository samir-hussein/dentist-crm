<?php

namespace App\Http\Services\Diagnosis;

use App\Http\Services\BaseService;
use App\Models\Diagnosis;

class DiagnosisService extends BaseService
{
    public function __construct(Diagnosis $model)
    {
        parent::__construct($model);
    }
}
