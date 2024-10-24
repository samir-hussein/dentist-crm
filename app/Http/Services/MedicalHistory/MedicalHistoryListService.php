<?php

namespace App\Http\Services\MedicalHistory;

class MedicalHistoryListService extends MedicalHistoryService
{
    public function boot()
    {
        $data = $this->model->get(['id', 'name']);

        return $data;
    }
}
