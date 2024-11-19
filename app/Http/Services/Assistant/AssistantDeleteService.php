<?php

namespace App\Http\Services\Assistant;

use App\Models\Assistant;

class AssistantDeleteService extends AssistantService
{
    public function boot(Assistant $assistant)
    {
        $assistant->delete();

        return $this->success();
    }
}
