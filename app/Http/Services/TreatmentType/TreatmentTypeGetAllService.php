<?php

namespace App\Http\Services\TreatmentType;

use Illuminate\Http\Request;

class TreatmentTypeGetAllService extends TreatmentTypeService
{
    public function boot(Request $request)
    {
        // Fetch all columns from your model's table
        $data = $this->model->latest()->select('*');

        return $this->dataTable($data, "treatment_types", $request);
    }
}
