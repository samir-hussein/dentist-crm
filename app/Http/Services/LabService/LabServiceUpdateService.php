<?php

namespace App\Http\Services\LabService;

use App\Models\LabService;

class LabServiceUpdateService extends LabServiceService
{
    public function boot(LabService $labService, array $data)
    {
        $labService->update($data);

        return $this->success();
    }
}
