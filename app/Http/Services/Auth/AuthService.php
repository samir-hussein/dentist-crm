<?php

namespace App\Http\Services\Auth;

use App\Http\Services\BaseService;
use App\Models\User;

class AuthService extends BaseService
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
