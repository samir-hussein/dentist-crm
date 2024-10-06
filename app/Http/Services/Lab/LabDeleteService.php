<?php

namespace App\Http\Services\Lab;

use App\Models\Lab;

class LabDeleteService extends LabService
{
    public function boot(Lab $lab)
    {
        $lab->delete();

        return $this->success();
    }
}
