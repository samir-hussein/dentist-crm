<?php

namespace App\Http\Services\Patient;

use App\Http\Services\BaseService;
use App\Models\Patient;

class PatientService extends BaseService
{
    public function __construct(Patient $model)
    {
        parent::__construct($model);
    }
}
