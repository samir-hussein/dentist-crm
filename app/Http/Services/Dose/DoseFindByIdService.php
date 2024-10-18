<?php

namespace App\Http\Services\Dose;

use App\Models\Dose;

class DoseFindByIdService extends DoseService
{
    public function boot(Dose $dose)
    {
        return $dose;
    }
}
