<?php

namespace App\Http\Services\Lab;

use App\Models\Lab;

class LabFindByIdService extends LabService
{
    public function boot(Lab $lab)
    {
        return $lab;
    }
}
