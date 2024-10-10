<?php

namespace App\Http\Services\Diagnosis;

use Illuminate\Http\Request;

class DiagnosisGetAllService extends DiagnosisService
{
    public function boot(Request $request)
    {
        // Fetch all columns from your model's table
        $data = $this->model->latest()->select(['id', 'name', 'description']);

        return $this->dataTable($data, "diagnoses", $request);
    }
}
