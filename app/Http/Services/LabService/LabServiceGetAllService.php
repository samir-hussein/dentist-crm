<?php

namespace App\Http\Services\LabService;

use Illuminate\Http\Request;

class LabServiceGetAllService extends LabServiceService
{
    public function boot(Request $request)
    {
        // Fetch all columns from your model's table
        $data = $this->model->latest()->select('*');

        return $this->dataTable($data, "lab_services", $request);
    }
}
