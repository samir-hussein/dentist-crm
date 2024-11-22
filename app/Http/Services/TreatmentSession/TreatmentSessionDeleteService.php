<?php

namespace App\Http\Services\TreatmentSession;

use App\Models\TreatmentDetail;

class TreatmentSessionDeleteService extends TreatmentSessionService
{
    public function boot(TreatmentDetail $treatmentDetail)
    {
        $treatmentDetail->delete();

        return $this->success();
    }
}
