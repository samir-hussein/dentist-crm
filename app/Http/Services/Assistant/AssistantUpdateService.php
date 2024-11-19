<?php

namespace App\Http\Services\Assistant;

use App\Models\Assistant;

class AssistantUpdateService extends AssistantService
{
    public function boot(Assistant $assistant, array $data)
    {
        $assistant->update($data);

        return $this->success();
    }
}
