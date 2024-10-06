<?php

namespace App\Http\Services\Lab;

use Illuminate\Http\Request;

class LabGetAllService extends LabService
{
    public function boot(Request $request)
    {
        // Fetch all columns from your model's table
        $data = $this->model->latest()->select('*');

        return $this->dataTable($data, "labs", $request);
    }
}
