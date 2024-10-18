<?php

namespace App\Http\Services\Dose;

use App\Models\Dose;

class DoseDeleteService extends DoseService
{
    public function boot(Dose $dose)
    {
        $dose->delete();

        return $this->success();
    }
}
