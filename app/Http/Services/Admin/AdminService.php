<?php

namespace App\Http\Services\Admin;

use App\Http\Services\BaseService;
use App\Models\User;

class AdminService extends BaseService
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
