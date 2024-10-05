<?php

namespace App\Http\Services\Staff;

use App\Http\Services\BaseService;
use App\Models\User;

class StaffService extends BaseService
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
