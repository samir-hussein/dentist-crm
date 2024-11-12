<?php

namespace App\Http\Services\Branch;

use App\Http\Services\BaseService;
use App\Models\Branch;

class BranchService extends BaseService
{
    public function __construct(Branch $model)
    {
        parent::__construct($model);
    }
}
