<?php

namespace App\Http\Services\LabService;

use App\Models\LabService;

class LabServiceDeleteService extends LabServiceService
{
    public function boot(LabService $labService)
    {
        $labService->delete();

        return $this->success();
    }
}
