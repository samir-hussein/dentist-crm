<?php

namespace App\Http\Services\Patient;

use Illuminate\Http\Request;

class PatientGetAllService extends PatientService
{
    public function boot(Request $request)
    {
        // Fetch all columns from your model's table
        $data = $this->model->latest()->select('*');

        return $this->dataTable($data, "patients", $request);
    }
}
