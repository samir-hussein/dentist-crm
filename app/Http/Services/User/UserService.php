<?php

namespace App\Http\Services\User;

use App\Http\Services\BaseService;
use App\Models\User;

class UserService extends BaseService
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
