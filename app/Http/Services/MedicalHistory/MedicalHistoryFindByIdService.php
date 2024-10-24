<?php

namespace App\Http\Services\MedicalHistory;

use Illuminate\Database\Eloquent\Model;

class MedicalHistoryFindByIdService extends MedicalHistoryService
{
    public function boot(Model $model)
    {
        return $model;
    }
}
