<?php

namespace App\Http\Services\Lab;

use App\Models\Lab;

class LabUpdateService extends LabService
{
    public function boot(Lab $lab, array $data)
    {
        $lab->update($data);

        return $this->success();
    }
}
