<?php

namespace App\Http\Services\Assistant;

use App\Http\Services\BaseService;
use App\Models\Assistant;

class AssistantService extends BaseService
{
    public function __construct(Assistant $model)
    {
        parent::__construct($model);
    }
}
