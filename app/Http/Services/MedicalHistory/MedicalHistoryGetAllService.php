<?php

namespace App\Http\Services\MedicalHistory;

use Illuminate\Http\Request;

class MedicalHistoryGetAllService extends MedicalHistoryService
{
    public function boot(Request $request)
    {
        // Fetch all columns from your model's table
        $data = $this->model->latest()->select('*');

        return $this->dataTable($data, "medical_histories", $request);
    }
}
