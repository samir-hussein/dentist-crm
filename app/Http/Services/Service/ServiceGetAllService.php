<?php

namespace App\Http\Services\Service;

use Illuminate\Http\Request;

class ServiceGetAllService extends ServiceService
{
    public function boot(Request $request)
    {
        // Fetch all columns from your model's table
        $data = $this->model->latest()->select('*');

        return $this->dataTable($data, "services", $request);
    }
}
