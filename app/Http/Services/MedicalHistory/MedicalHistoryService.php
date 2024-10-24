<?php

namespace App\Http\Services\MedicalHistory;

use App\Http\Services\BaseService;
use App\Models\MedicalHistory;

class MedicalHistoryService extends BaseService
{
    public function __construct(MedicalHistory $model)
    {
        parent::__construct($model);
    }
}
