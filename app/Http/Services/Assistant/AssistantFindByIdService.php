<?php

namespace App\Http\Services\Assistant;

use App\Models\Assistant;

class AssistantFindByIdService extends AssistantService
{
    public function boot(Assistant $assistant)
    {
        return $assistant;
    }
}
