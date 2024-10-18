<?php

namespace App\Http\Services\Dose;

use App\Models\Dose;

class DoseUpdateService extends DoseService
{
    public function boot(Dose $dose, array $data)
    {
        $dose->update($data);

        return $this->success();
    }
}
