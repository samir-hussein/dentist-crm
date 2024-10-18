<?php

namespace App\Http\Services\LabService;

use App\Models\LabService;

class LabServiceFindByIdService extends LabServiceService
{
    public function boot(LabService $labService)
    {
        return $labService;
    }
}
