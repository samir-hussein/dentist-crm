<?php

namespace App\Http\Services\TreatmentSession;

use App\Http\Services\BaseService;
use App\Models\TreatmentDetail;

class TreatmentSessionService extends BaseService
{
    public function __construct(TreatmentDetail $model)
    {
        parent::__construct($model);
    }
}
