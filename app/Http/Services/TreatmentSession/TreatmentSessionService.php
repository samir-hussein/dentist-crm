<?php

namespace App\Http\Services\TreatmentSession;

use App\Http\Services\BaseService;
use App\Models\Appointment;

class TreatmentSessionService extends BaseService
{
    public function __construct(Appointment $model)
    {
        parent::__construct($model);
    }
}
