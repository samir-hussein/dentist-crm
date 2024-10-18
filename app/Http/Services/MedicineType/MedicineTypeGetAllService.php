<?php

namespace App\Http\Services\MedicineType;

use Illuminate\Http\Request;

class MedicineTypeGetAllService extends MedicineTypeService
{
    public function boot(Request $request)
    {
        // Fetch all columns from your model's table
        $data = $this->model->latest()->select('*');

        return $this->dataTable($data, "medicine_types", $request);
    }
}
