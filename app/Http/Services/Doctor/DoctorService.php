<?php

namespace App\Http\Services\Doctor;

use App\Http\Services\BaseService;
use App\Models\User;

class DoctorService extends BaseService
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
