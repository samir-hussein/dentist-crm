<?php

namespace App\Http\Services\Appointment;

use App\Http\Services\BaseService;
use App\Models\Appointment;

class AppointmentService extends BaseService
{
    public function __construct(Appointment $model)
    {
        parent::__construct($model);
    }
}
