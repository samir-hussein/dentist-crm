<?php

namespace App\Http\Services\Assistant;

class AssistantStoreService extends AssistantService
{
    public function boot(array $data)
    {
        $this->model->create($data);

        return $this->success();
    }
}
